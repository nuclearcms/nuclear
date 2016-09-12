<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Nuclear\Hierarchy\Exception\InvalidParentNodeTypeException;
use Nuclear\Hierarchy\Node;
use Nuclear\Hierarchy\NodeSource;
use Nuclear\Hierarchy\Tags\Tag;
use Reactor\Http\Controllers\Traits\UsesNodeForms;
use Reactor\Http\Controllers\Traits\UsesNodeHelpers;
use Reactor\Http\Controllers\Traits\UsesTranslations;
use Reactor\Statistics\NodeStatisticsCompiler;

class NodesController extends ReactorController {

    use UsesTranslations, UsesNodeHelpers, UsesNodeForms;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodes = Node::sortable()
            ->filteredByStatus()
            ->paginate();

        return $this->compileView('nodes.index', compact('nodes'), trans('nodes.all'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        // Because of the searchable trait we are adding the global scopes from scratch
        $nodes = Node::withoutGlobalScopes()
            ->typeMailing()
            ->filteredByStatus()
            ->groupBy('id')
            // Search should be the last
            ->search($request->input('q'), 20, true)
            ->get();

        return $this->compileView('nodes.search', compact('nodes'));
    }

    /**
     * Returns the collection of retrieved nodes by json response
     *
     * @param Request $request
     * @return Response
     */
    public function searchJson(Request $request)
    {
        // Because of the searchable trait we are adding the global scopes from scratch
        $nodes = Node::withoutGlobalScopes()
            ->typeMailing()
            ->groupBy('id')->limit(10);

        $filter = $request->input('filter', 'all');

        if ($filter !== 'all')
        {
            $nodes->withType($filter);
        }

        // Search must be last
        $nodes = $nodes->search($request->input('q'), 20, true)->get();

        $results = [];

        foreach ($nodes as $node)
        {
            $results[$node->getKey()] = $node->getTitle();
        }

        return response()->json($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int|null $id
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $this->authorize('EDIT_NODES');

        $parent = ! is_null($id) ? Node::findOrFail($id) : null;

        $this->validateParentCanHaveChildren($parent);

        $form = $this->getCreateForm($id, $parent);

        return $this->compileView('nodes.create', compact('form', 'parent'),
            ($parent) ? trans('nodes.add_child') : trans('nodes.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param int|null $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {
        $this->authorize('EDIT_NODES');

        $this->validateCreateForm($request);

        list($node, $locale) = $this->createNode($request, $id);

        $this->notify('nodes.created');

        return redirect()->route('reactor.nodes.edit', [
            $node->getKey(),
            $node->translate($locale)->getKey()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param int|null $source
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $source = null)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source);

        $form = $this->getEditForm($id, $node, $source);

        return $this->compileView('nodes.edit', compact('form', 'node', 'locale', 'source'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param int $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $source)
    {
        $node = $this->authorizeAndFindNode($id, $source, 'EDIT_NODES', false);

        if($response = $this->validateNodeIsNotLocked($node)) return $response;

        list($locale, $source) = $this->determineLocaleAndSource($source, $node);

        $this->validateEditForm($request, $node, $source);

        $this->determinePublish($request, $node);

        // Recording paused for this, otherwise two records are registered
        chronicle()->pauseRecording();
        $node->update([
            $locale => $request->all()
        ]);
        // and resume
        chronicle()->resumeRecording();

        $this->notify('nodes.edited', 'updated_node_content', $node);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resources parameters.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editParameters($id)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, null, 'EDIT_NODES');

        $form = $this->getEditParametersForm($id, $node);

        return $this->compileView('nodes.parameters', compact('form', 'node', 'source'));
    }

    /**
     * Update the specified resources paramaters in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateParameters(Request $request, $id)
    {
        $node = $this->authorizeAndFindNode($id, null, 'EDIT_NODES', false);

        $this->validateEditParametersForm($request);

        $this->determineHomeNode($request, $id);

        $node->fill($request->all());

        $this->determinePublish($request, $node);
        $node->save();

        $this->notify('nodes.edited_parameters');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('EDIT_NODES');

        $node = Node::findOrFail($id);

        if($response = $this->validateNodeIsNotLocked($node)) return $response;

        $node->delete();

        $this->notify('nodes.destroyed');

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        $this->authorize('EDIT_NODES');

        $ids = json_decode($request->input('_bulkSelected', '[]'));

        Node::whereIn('id', $ids)
            ->whereLocked(0)->delete();

        $this->notify('nodes.destroyed', 'deleted_nodes');

        return redirect()->back();
    }

    /**
     * Shows the children nodes of the resource in list view
     *
     * @param int $id
     * @param int $source
     * @return Response
     */
    public function childrenList($id, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source);

        $children = $node->children()
            ->sortable()
            ->translatedIn($locale)
            ->paginate();

        return $this->compileView('nodes.children_list', compact('node', 'source', 'children', 'locale'), trans('nodes.children'));
    }

    /**
     * Shows the children nodes of the resourse in tree view
     *
     * @param int $id
     * @return Response
     */
    public function childrenTree($id)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, null);

        return $this->compileView('nodes.children_tree', compact('node', 'source'), trans('nodes.children'));
    }

    /**
     * Adds a translation to the resource
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function createTranslation($id)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, null, 'EDIT_NODES');

        if (count($locales = $this->getAvailableLocales($node)) === 0)
        {
            flash()->error(trans('general.no_available_locales'));

            return redirect()->back();
        }

        $form = $this->getCreateTranslationForm($id, $locales);

        return $this->compileView('nodes.translate', compact('form', 'node', 'source'), trans('general.add_translation'));
    }

    /**
     * Stores a translation in the resource
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storeTranslation(Request $request, $id)
    {
        $this->authorize('EDIT_NODES');

        $node = Node::findOrFail($id);

        if($response = $this->validateNodeIsNotLocked($node)) return $response;

        $this->validateCreateTranslationForm($request);

        $locale = $this->validateLocale($request);

        // Recording paused for this, otherwise two records are registered
        chronicle()->pauseRecording();
        $node->update([
            $locale => $request->all()
        ]);
        // and resume
        chronicle()->resumeRecording();

        $this->notify('general.added_translation', 'created_node_translation', $node);

        return redirect()->route('reactor.nodes.edit', [
            $node->getKey(),
            $node->translate($locale)->getKey()
        ]);
    }

    /**
     * Deletes a translation
     *
     * @param int $id
     * @return Response
     */
    public function destroyTranslation($id)
    {
        $this->authorize('EDIT_NODES');

        $source = NodeSource::findOrFail($id);
        $node = $source->node;

        if($response = $this->validateNodeIsNotLocked($node)) return $response;

        $source->delete();

        $node->load('translations');

        $this->notify('general.destroyed_translation', 'deleted_node_translation', $node);

        return redirect()->route('reactor.nodes.edit', [$node->getKey(), $node->translateOrfirst()->getKey()]);
    }

    /**
     * Show the page for resource transformation options
     *
     * @param int $id
     * @return Response
     */
    public function transform($id)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, null, 'EDIT_NODES');

        $form = $this->getTransformForm($id, $node);

        return $this->compileView('nodes.transform', compact('node', 'form', 'source'));
    }

    /**
     * Transforms the resource into given type
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function transformPut(Request $request, $id)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, null, 'EDIT_NODES');

        $this->validateTransformForm($request);

        if($response = $this->validateNodeIsNotLocked($node)) return $response;

        try {
            // Recording paused for this, otherwise two records are registered
            chronicle()->pauseRecording();
            $node->transformInto($request->input('type'));
            // and resume
            chronicle()->resumeRecording();

            $this->notify('nodes.transformed', 'transformed_node', $node);
        } catch (InvalidParentNodeTypeException $e)
        {
            $this->notify('nodes.invalid_parent', null, null, 'error');
        }

        return redirect()->route('reactor.nodes.edit', [$id, $source->getKey()]);
    }

    /**
     * Show the page for resource moving options
     *
     * @param int $id
     * @return Response
     */
    public function move($id)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, null, 'EDIT_NODES');

        $form = $this->getMoveForm($id);

        return $this->compileView('nodes.move', compact('node', 'form', 'source'));
    }

    /**
     * Transforms the node into given type
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function movePut(Request $request, $id)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, null, 'EDIT_NODES');

        $this->validateMoveForm($request);

        if($response = $this->validateNodeIsNotLocked($node)) return $response;

        if ($parent = Node::find(request()->input('parent')))
        {
            try
            {
                // Recording paused for this, otherwise two records are registered
                chronicle()->pauseRecording();
                $node->appendToNode($parent);
                $node->save();
                // and resume
                chronicle()->resumeRecording();

                $this->notify('nodes.moved', 'moved_node', $node);
            } catch (InvalidParentNodeTypeException $e)
            {
                $this->notify('nodes.invalid_parent', null, null, 'error');
            }
        } else
        {
            $this->notify('nodes.invalid_parent', null, null, 'error');
        }

        return redirect()->route('reactor.nodes.edit', [$id, $source->getKey()]);
    }

    /**
     * Changes the displayed tree locale
     *
     * @param Request $request
     * @return void
     */
    public function changeTreeLocale(Request $request)
    {
        $locale = $this->validateLocale($request);

        session()->set('reactor.tree_locale', $locale);
    }

    /**
     * Changes a nodes location in the tree
     *
     * @param Request $request
     * @return response
     */
    public function sortTree(Request $request)
    {
        $response = [
            'type'    => 'danger',
            'message' => trans('general.error_saving')
        ];

        if (Gate::denies('EDIT_NODES'))
        {
            $response['message'] = trans('general.not_authorized');

            return response()->json($response);
        }

        $node = Node::find($request->input('node'));
        $sibling = Node::find($request->input('sibling'));

        if (is_null($node) || is_null($sibling))
        {
            $response['message'] = trans('nodes.sort_invalid');

            return response()->json($response);
        }

        if ($node->isLocked())
        {
            $response['message'] = trans('nodes.node_is_locked');

            return response()->json($response);
        }

        try
        {
            if ($request->input('action') === 'after')
            {
                $node->afterNode($sibling);
            }

            if ($request->input('action') === 'before')
            {
                $node->beforeNode($sibling);
            }

            // Touch the model so that model will be dirty and the
            // saving event will run. (We have to do this because saving event
            // do not fire in Translatable's save method if parent model is not dirty.
            $node->touch();

            if ( ! $node->save())
            {
                return response()->json($response);
            }
        } catch (InvalidParentNodeTypeException $e)
        {
            $response['message'] = trans('nodes.invalid_parent');

            return response()->json($response);
        }

        $parentNode = request()->input('parent');

        $leafs = ($parentNode !== '0') ?
            Node::findOrFail($parentNode)->getPositionOrderedChildren() :
            Node::whereIsRoot()->defaultOrder()->get();

        return response()->json([
            'type' => 'success',
            'html' => view('partials.navigation.node_trees', ['leafs' => $leafs])->render()
        ]);
    }

    /**
     * Publishes the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        return $this->changeNodeStatus($id, 'publish', 'published');
    }

    /**
     * Unpublishes the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function unpublish($id)
    {
        return $this->changeNodeStatus($id, 'unpublish', 'unpublished');
    }

    /**
     * Locks the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function lock($id)
    {
        return $this->changeNodeStatus($id, 'lock', 'locked');
    }

    /**
     * Unlocks the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function unlock($id)
    {
        return $this->changeNodeStatus($id, 'unlock', 'unlocked');
    }

    /**
     * Shows the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->changeNodeStatus($id, 'show', 'showed');
    }

    /**
     * Hides the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function hide($id)
    {
        return $this->changeNodeStatus($id, 'hide', 'hid');
    }

    /**
     * Stores a tag for the resource
     *
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function storeTag(Request $request, $id)
    {
        $this->authorize('EDIT_TAGS');
        $node = $this->authorizeAndFindNode($id, null, 'EDIT_NODES', false);

        if ($node->isLocked())
        {
            return response()->json([
                'type'    => 'danger',
                'message' => trans('nodes.node_is_locked')
            ]);
        }

        $this->validate($request, ['title' => 'required|max:255']);

        $tag = Tag::firstByTitleOrCreate($request->input('title'));

        $node->attachTag($tag->getKey());

        return response()->json([
            'type' => 'success',
            'tag' =>[
                'id'   => $tag->getKey(),
                'title' => $tag->title,
                'translatable' => $tag->canHaveMoreTranslations(),
                'editurl' => route('reactor.tags.edit', [$tag->getKey(), $tag->translate()->getKey()]),
                'translateurl' => route('reactor.tags.translations.create', [$tag->getKey(), $tag->translate()->getKey()])
        ]]);
    }

    /**
     * Attaches a tag to the resource
     *
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function attachTag(Request $request, $id)
    {
        return $this->attachOrDetachTag($request, $id, 'attach');
    }

    /**
     * Detaches a tag from the resource
     *
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function detachTag(Request $request, $id)
    {
        return $this->attachOrDetachTag($request, $id, 'detach');
    }

    /**
     * Shows the statistics for the resource
     *
     * @param NodeStatisticsCompiler $compiler
     * @param int $id
     * @return view
     */
    public function statistics(NodeStatisticsCompiler $compiler, $id)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id);

        $statistics = $compiler->compileStatistics($node);

        return $this->compileView('nodes.statistics', compact('node', 'locale', 'source', 'statistics'), trans('general.statistics'));
    }

}