<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Nuclear\Hierarchy\Node;
use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\UsesNodeForms;
use Reactor\Http\Controllers\Traits\UsesNodeHelpers;
use Reactor\Http\Controllers\Traits\UsesTranslations;

class NodesController extends ReactorController {

    use UsesTranslations, UsesNodeHelpers, UsesNodeForms, BasicResource;

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = Node::class;
    protected $resourceMultiple = 'nodes';
    protected $resourceSingular = 'node';
    protected $permissionKey = 'NODES';

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
        $nodes = Node::search($request->input('q'), 20, true)
            ->filteredByStatus()
            ->groupBy('id')
            ->get();

        return $this->compileView('nodes.search', compact('nodes'));
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
        } catch (\Exception $e)
        {
            if (is_a($e, 'Nuclear\Hierarchy\Exception\InvalidParentNodeTypeException'))
            {
                $response['message'] = trans('nodes.invalid_parent');
            }

            return response()->json($response);
        }

        return response()->json([
            'type' => 'success',
            'html' => view('partials.navigation.node_trees')->render()
        ]);
    }

}