<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
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

        return $this->compileView('nodes.create', compact('form', 'parent'));
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

}