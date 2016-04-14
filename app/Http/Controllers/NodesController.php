<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\NodeSource;
use Reactor\Http\Controllers\Traits\ModifiesTranslations;
use Reactor\Http\Controllers\Traits\UsesNodeForms;
use Reactor\Http\Controllers\Traits\UsesNodeHelpers;
use Reactor\Http\Requests;
use Reactor\Nodes\Node;
use Reactor\Statistics\NodeStatisticsCompiler;
use Reactor\Tags\Tag;

class NodesController extends ReactorController {

    use ModifiesTranslations, UsesNodeForms, UsesNodeHelpers;

    /**
     * Lists resources with given scope
     *
     * @param string $scope
     * @param string|null $locale
     * @return Response
     */
    public function index($scope, $locale = null)
    {
        $this->validateScope($scope);
        $locale = $this->validateLocale($locale, true);

        $nodes = Node::sortable()
            ->{camel_case($scope)}()
            ->translatedIn($locale)
            ->paginate();

        return view('nodes.index', compact('nodes', 'scope', 'locale'));
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
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS');

        $children = $node->children()
            ->sortable()
            ->translatedIn($locale)
            ->paginate();

        return view('nodes.list', compact('node', 'source', 'children', 'locale'));
    }

    /**
     * Shows the children nodes of the resourse in tree view
     *
     * @param int $id
     * @param int $source
     * @return Response
     */
    public function tree($id, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS');

        return view('nodes.tree', compact('node', 'source'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $nodes = Node::search($request->input('q'), 20, true)
            ->distinct()->get();

        return view('nodes.search')
            ->with(compact('nodes'));
    }

    /**
     * Returns the collection of retrieved nodes by json response
     *
     * @param Request $request
     * @return Response
     */
    public function jsonSearch(Request $request)
    {
        $nodes = Node::search($request->input('q'), 20, true)
            ->distinct()->limit(10)->get();

        $nodes = $nodes->lists('title', 'id');

        return response()->json($nodes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int|null $id
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $this->authorize('ACCESS_CONTENTS_CREATE');

        $parent = ! is_null($id) ? Node::findOrFail($id) : null;

        $this->validateParentCanHaveChildren($parent);

        $form = $this->getCreateNodeForm($id);

        return view('nodes.create', compact('form', 'parent'));
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
        $this->authorize('ACCESS_NODES_CREATE');

        $this->validateForm('Reactor\Http\Forms\Nodes\CreateNodeForm', $request);

        list($node, $locale) = $this->createNode($request, $id);

        $this->notify('nodes.created');

        return redirect()->route('reactor.contents.edit', [
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
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT');

        $form = $this->getEditNodeForm($id, $node, $source);

        // This is for enabling deleting translation
        $translated = true;

        return view('nodes.edit', compact('form', 'node', 'locale', 'source', 'translated'));
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
        $node = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT', false);

        if ($node->isLocked())
        {
            $this->notify('nodes.node_not_editable', null, null, 'error');
        } else
        {
            list($locale, $source) = $this->determineLocaleAndSource($source, $node);

            $this->validateUpdateNodeForm($request, $node, $source);

            $this->determinePublish($request, $node);

            // Recording paused for this, otherwise two records are registered
            chronicle()->pauseRecording();
            $node->update([
                $locale => $request->all()
            ]);
            // and resume
            chronicle()->resumeRecording();

            $this->notify('nodes.edited', 'updated_node_content', $node);
        }

        return redirect()->back();
    }

    /**
     * Adds a translation to the resource
     *
     * @param  int $id
     * @param int $source
     * @return \Illuminate\Http\Response
     */
    public function createTranslation($id, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT');

        if (count($locales = $this->getAvailableLocales($node)) === 0)
        {
            flash()->error(trans('nodes.no_available_locale'));

            return redirect()->back();
        }

        $form = $this->getCreateNodeTranslationForm($node, $locales);

        return view('nodes.translate', compact('form', 'node', 'source'));
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
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_EDIT', false);

        $this->validateCreateNodeTranslationForm($request, $node);

        $locale = $this->validateLocale($request);

        $node->update([
            $locale => $request->all()
        ]);

        $this->notify('nodes.added_translation', 'created_node_translation', $node);

        return redirect()->route('reactor.contents.edit', [
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
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $source = NodeSource::findOrFail($id);

        $node = $source->node;

        if ($node->isLocked())
        {
            $this->notify('nodes.node_not_editable', null, null, 'error');
        } else
        {
            $source->delete();

            $node->load('translations');

            $sourceId = ($source->locale === app()->getLocale()) ? $node->translations->first()->getKey() : null;

            $this->notify('nodes.deleted_translation', 'deleted_node_translation', $node);
        }

        return redirect()->route('reactor.contents.edit', [$node->getKey(), $sourceId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param bool|string $self
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $self = false)
    {
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_DELETE', false);

        if ($node->isLocked())
        {
            $this->notify('nodes.node_not_editable', null, null, 'error');
        } else
        {
            $node->delete();

            $this->notify('nodes.deleted');
        }

        if ($self === 'self')
        {
            return redirect()->route('reactor.dashboard');
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resources parameters.
     *
     * @param  int $id
     * @param int $source
     * @return \Illuminate\Http\Response
     */
    public function parameters($id, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT');

        $form = $this->getEditNodeParametersForm($id, $node, $source->getKey());

        return view('nodes.parameters', compact('form', 'node', 'source'));
    }

    /**
     * Update the specified resources paramaters in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param int $source
     * @return \Illuminate\Http\Response
     */
    public function updateParameters(Request $request, $id, $source)
    {
        $node = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT', false);

        $this->validateForm('Reactor\Http\Forms\Nodes\EditNodeParametersForm', $request);

        $this->determineHomeNode($request, $id);

        $node->fill(
            $this->filterTimeInput($request)
        );
        $this->determinePublish($request, $node);
        $node->save();

        $this->notify('nodes.edited');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resources seo params.
     *
     * @param int $id
     * @param int $source
     * @return \Illuminate\Http\Response
     */
    public function seo($id, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT');

        $form = $this->getEditNodeSEOForm($id, $source);

        // This is for enabling deleting translation
        $translated = true;

        return view('nodes.seo', compact('form', 'node', 'locale', 'source', 'translated'));
    }

    /**
     * Update the specified resources seo params in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param int $source
     * @return \Illuminate\Http\Response
     */
    public function updateSEO(Request $request, $id, $source)
    {
        $node = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT', false);

        if ($node->isLocked())
        {
            $this->notify('nodes.node_not_editable', null, null, 'error');
        } else
        {
            list($locale, $source) = $this->determineLocaleAndSource($source, $node);

            $this->validateForm('Reactor\Http\Forms\Nodes\EditNodeSEOForm', $request);

            $this->determinePublish($request, $node);
            $node->update([
                $locale => $request->all()
            ]);

            $this->notify('nodes.edited', 'updated_node_seo', $node);
        }

        return redirect()->back();
    }

    /**
     * Shows the children nodes of the resourse in tree view
     *
     * @param int $id
     * @param int $source
     * @return Response
     */
    public function tags($id, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT');

        return view('nodes.tags', compact('node', 'source'));
    }

    /**
     * Adds a tag to the node
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function addTag(Request $request, $id)
    {
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_EDIT', false);

        $this->validate($request, ['name' => 'required|max:255']);

        $tag = Tag::firstByNameOrCreate($request->input('name'));

        $node->attachTag($tag->getKey());

        return response()->json([
            'id'   => $tag->getKey(),
            'name' => $tag->name
        ]);
    }

    /**
     * Unlinks a tag from the node
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function detachTag(Request $request, $id)
    {
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_EDIT', false);

        $node->detachTag($request->input('tag'));

        return response()->json(['id' => $request->input('tag')]);
    }

    /**
     * Displays statistics about the node
     *
     * @param NodeStatisticsCompiler $compiler
     * @param int $id
     * @param int $source
     * @return Response
     */
    public function statistics(NodeStatisticsCompiler $compiler, $id, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT');

        // This is for enabling deleting translation
        $translated = true;

        $statistics = $compiler->collectNodeStatistics($node, $locale);

        return view('nodes.statistics', compact('node', 'locale', 'source', 'translated', 'statistics'));
    }

    /**
     * Show the page for resource transformation options
     *
     * @param int $id
     * @param int $source
     * @return Response
     */
    public function transform($id, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT');

        $form = $this->getTransformNodeForm($id, $node, $source->getKey());

        return view('nodes.transform', compact('node', 'form', 'source'));
    }

    /**
     * Transforms the node into given type
     *
     * @param Request $request
     * @param int $id
     * @param int $source
     * @return Response
     */
    public function transformPut(Request $request, $id, $source)
    {
        list($node, $locale, $source) = $this->authorizeAndFindNode($id, $source, 'ACCESS_CONTENTS_EDIT');

        $node->transformInto($request->input('type'));

        $this->notify('nodes.transformed_node', 'transformed_node', $node);

        return redirect()->route('reactor.contents.edit', [$id, $source->getKey()]);
    }


    /**
     * Publishes the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_EDIT', false);

        $node->publish()->save();

        $this->notify('nodes.published_node');

        return redirect()->back();
    }

    /**
     * Unpublishes the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function unpublish($id)
    {
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_EDIT', false);

        $node->unpublish()->save();

        $this->notify('nodes.unpublished_node');

        return redirect()->back();
    }

    /**
     * Locks the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function lock($id)
    {
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_EDIT', false);

        $node->lock()->save();

        $this->notify('nodes.locked_node');

        return redirect()->back();
    }

    /**
     * Unlocks the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function unlock($id)
    {
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_EDIT', false);

        $node->unlock()->save();

        $this->notify('nodes.unlocked_node');

        return redirect()->back();
    }

    /**
     * Shows the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_EDIT', false);

        $node->show()->save();

        $this->notify('nodes.showed_node');

        return redirect()->back();
    }

    /**
     * Hides the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function hide($id)
    {
        $node = $this->authorizeAndFindNode($id, null, 'ACCESS_CONTENTS_EDIT', false);

        $node->hide()->save();

        $this->notify('nodes.hid_node');

        return redirect()->back();
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
     * Sorts the node inside the tree
     *
     * @param Request $request
     * @return void
     */
    public function sortNode(Request $request)
    {
        $node = Node::findOrFail($request->input('node'));
        $sibling = Node::findOrFail($request->input('sibling'));

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

        return response()->json(['save' => $node->save()]);
    }

}
