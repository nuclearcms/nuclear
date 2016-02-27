<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;

use Reactor\Http\Requests;
use Reactor\Nodes\Node;
use Reactor\Nodes\NodeType;

class NodesController extends ReactorController {

    /**
     * Shows the children nodes of the resourse
     *
     * @param int $id
     * @return Response
     */
    public function tree($id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        return view('nodes.tree', compact('node'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $nodes = Node::search($request->input('q'))->get();

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
        $nodes = Node::search($request->input('q'))
            ->limit(10)->get();

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
     * Validates if the parent can have children nodes
     *
     * @param $parent
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function validateParentCanHaveChildren($parent)
    {
        if ($parent && $parent->sterile)
        {
            abort(500, 'Node is sterile.');
        }
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

        $node = $this->createNode($request, $id);

        $this->notify('nodes.created');

        return redirect()->route('reactor.contents.edit', $node->getKey());
    }

    /**
     * @param Request $request
     * @param $id
     * @return static
     */
    protected function createNode(Request $request, $id)
    {
        $node = new Node;

        $node->setNodeTypeByKey($request->input('type'));

        $node->fill([
            config('app.locale') => $request->all()
        ]);

        $node = $this->locateNodeInTree($id, $node);

        $node->save();

        return $node;
    }

    /**
     * @param $id
     * @param $node
     * @return mixed
     */
    protected function locateNodeInTree($id, $node)
    {
        if (is_null($id))
        {
            return $node->makeRoot();
        }

        $parent = Node::findOrFail($id);
        $node->appendTo($parent);

        return $node;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param int $source
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $source = null)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        list($locale, $source) = $this->determineLocaleAndSource($source, $node);

        $form = $this->getEditNodeForm($id, $node, $source);

        return view('nodes.edit', compact('form', 'node', 'locale', 'source'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param int $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $source = null)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        if ($node->isLocked())
        {
            $this->notify('nodes.node_not_editable', null, null, 'error');
        } else
        {
            list($locale, $source) = $this->determineLocaleAndSource($source, $node);

            $this->validateUpdateNodeForm($request, $node, $source);

            $this->determinePublish($request, $node);
            $node->update([
                $locale => $request->all()
            ]);

            $this->notify('nodes.edited', 'updated_node_content', $node);
        }

        return redirect()->back();
    }

    /**
     * Determines the node publishing
     *
     * @param Request $request
     * @param $node
     */
    public function determinePublish(Request $request, $node)
    {
        if ($request->get('_publish') === 'publish')
        {
            $node->publish();
        }
    }

    /**
     * Publishes the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

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
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $node->unpublish()->save();

        $this->notify('nodes.unpublished_node');

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
        $this->authorize('ACCESS_CONTENTS_DELETE');

        $node = Node::findOrFail($id);

        $node->delete();

        $this->notify('nodes.deleted');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resources seo params.
     *
     * @param int $id
     * @param int|null $source
     * @return \Illuminate\Http\Response
     */
    public function seo($id, $source = null)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        list($locale, $source) = $this->determineLocaleAndSource($source, $node);

        $form = $this->getEditNodeSEOForm($id, $source);

        return view('nodes.seo', compact('form', 'node', 'locale', 'source'));
    }

    /**
     * Update the specified resources seo params in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param int|null $source
     * @return \Illuminate\Http\Response
     */
    public function updateSEO(Request $request, $id, $source = null)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

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
     * Determines the current editing locale
     *
     * @param $source
     * @param $node
     * @return string
     */
    protected function determineLocaleAndSource($source, $node)
    {
        if ($source)
        {
            $source = $node->translations->find($source);

            if (is_null($source))
            {
                abort(404);
            }
        } else
        {
            $source = $node->translate();
        }

        return [$source->locale, $source];
    }

    /**
     * Show the form for editing the specified resources parameters.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function parameters($id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $form = $this->getEditNodeParametersForm($id, $node);

        return view('nodes.parameters', compact('form', 'node'));
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
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $this->validateForm('Reactor\Http\Forms\Nodes\EditNodeParametersForm', $request);

        $this->determineHomeNode($request, $id);

        $node->fill(
            $this->filterTimeInput($request)
        );
        $this->determinePublish($request, $node);
        $node->save();

        $this->notify('nodes.edited');

        return redirect()->route('reactor.contents.parameters', $id);
    }

    /**
     * Locks the specified resource
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function lock($id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

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
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

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
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

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
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $node->hide()->save();

        $this->notify('nodes.hid_node');

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function filterTimeInput(Request $request)
    {
        if (empty($request->input('published_at')))
        {
            return $request->except('published_at');
        }

        return $request->all();
    }

    /**
     * @param Request $request
     */
    protected function determineHomeNode(Request $request, $id)
    {
        if ($request->input('home') === '1')
        {
            $home = Node::whereHome(1)->where('id', '<>', $id)->first();

            if ($home)
            {
                $home->update(['home' => 0]);
            }
        }
    }

    /**
     * Adds a translation to the resource
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function createTranslation($id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        // Check if there are any available locales
        if (count($node->translations) >= locale_count())
        {
            flash()->error(trans('nodes.no_available_locale'));

            return redirect()->back();
        }

        $locales = $this->getAvailableLocales($node);

        $form = $this->getCreateNodeTranslationForm($node, $locales);

        return view('nodes.translate', compact('form', 'node'));
    }

    /**
     * @param $node
     * @return array
     */
    protected function getAvailableLocales($node)
    {
        $locales = [];

        $nodeTranslations = $node->translations
            ->lists('locale')->toArray();

        foreach (config('translatable.locales') as $locale)
        {
            if ( ! in_array($locale, $nodeTranslations))
            {
                $locales[$locale] = trans('general.' . $locale);
            }
        }

        return $locales;
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
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $this->validateCreateNodeTranslationForm($request, $node);

        $locale = $this->validateLocale($request);

        $node->update([
            $locale => $request->all()
        ]);

        $this->notify('nodes.added_translation', 'created_node_translation', $node);

        return redirect()->route('reactor.contents.edit', [
            'id'     => $node->getKey(),
            'source' => $node->translate($locale)->getKey()
        ]);
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function validateLocale(Request $request)
    {
        $locale = $request->input('locale');

        if ( ! in_array($locale, config('translatable.locales')))
        {
            abort(500);
        }

        return $locale;
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

    /**
     * @param int|null $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateNodeForm($id)
    {
        $form = $this->form('Reactor\Http\Forms\Nodes\CreateNodeForm', [
            'url' => route('reactor.contents.store', $id)
        ]);

        $nodeTypes = NodeType::whereVisible(1)
            ->lists('label', 'id')
            ->toArray();

        $form->modify('type', 'select', [
            'choices' => $nodeTypes
        ]);

        return $form;
    }

    /**
     * @param $id
     * @param $node
     * @param $source
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeForm($id, $node, $source)
    {
        $nodeType = $node->nodeType->name;
        $nodeTypeForm = 'gen\\Forms\\' . source_form_name($nodeType);

        $params = [
            'id'     => $id,
            'source' => $source->getKey()
        ];

        $form = $this->form($nodeTypeForm, [
            'url'   => route('reactor.contents.update', $params),
            // We do this because object_get method does not work for node sources
            // which FormBuilder uses to access attributes
            // Instead we prefer it to use array_get since toArray from Hierarchy
            // retrieves data properly.
            'model' => $source->toArray()
        ]);

        return $form;
    }

    /**
     * @param $id
     * @param $source
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeSEOForm($id, $source)
    {
        $params = [
            'id'     => $id,
            'source' => $source->getKey()
        ];

        $form = $this->form('Reactor\Http\Forms\Nodes\EditNodeSEOForm', [
            'url'   => route('reactor.contents.seo.update', $params),
            'model' => $source
        ]);

        return $form;
    }

    /**
     * @param Request $request
     * @param $node
     * @param $source
     */
    protected function validateUpdateNodeForm(Request $request, $node, $source)
    {
        $this->validateForm(
            'gen\\Forms\\' . source_form_name($node->nodeType->name),
            $request, [
            'node_name' => 'max:255|alpha_dash|unique:node_sources,node_name,' . $source->getKey()
        ]);
    }

    /**
     * @param $id
     * @param $node
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeParametersForm($id, $node)
    {
        $form = $this->form('Reactor\Http\Forms\Nodes\EditNodeParametersForm', [
            'url'   => route('reactor.contents.parameters.update', $id),
            'model' => $node
        ]);

        return $form;
    }

    /**
     * @param $node
     * @param array $locales
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateNodeTranslationForm($node, $locales)
    {
        $nodeType = $node->nodeType->name;
        $nodeTypeForm = 'gen\\Forms\\' . source_form_name($nodeType);

        $form = $this->form($nodeTypeForm, [
            'method' => 'post',
            'url'    => route('reactor.contents.translation.store', $node->getKey())
        ]);


        $form->addBefore('title', 'locale', 'select', [
            'choices' => $locales
        ]);

        return $form;
    }

    /**
     * @param Request $request
     * @param $node
     */
    protected function validateCreateNodeTranslationForm(Request $request, $node)
    {
        $this->validateForm(
            'gen\\Forms\\' . source_form_name($node->nodeType->name),
            $request);
    }

}
