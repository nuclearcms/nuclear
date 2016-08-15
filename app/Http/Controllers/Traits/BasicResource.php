<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;

trait BasicResource {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        extract($this->getResourceNames());

        $items = $modelPath::sortable()->paginate();

        return $this->compileView($resourceMultiple . '.index', [$resourceMultiple => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        extract($this->getResourceNames());

        $this->authorize('EDIT_' . $permissionKey);

        $form = $this->getCreateForm();

        return $this->compileView($resourceMultiple . '.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        extract($this->getResourceNames());

        $this->authorize('EDIT_' . $permissionKey);

        $this->validateCreateForm($request);

        $item = $modelPath::create($request->all());

        $this->notify($resourceMultiple . '.created');

        return redirect()->route('reactor.' . $resourceMultiple . '.edit', $item->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        extract($this->getResourceNames());

        $item = $modelPath::findOrFail($id);

        $form = $this->getEditForm($id, $item);

        return $this->compileView($resourceMultiple . '.edit', ['form' => $form, $resourceSingular => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        extract($this->getResourceNames());

        $this->authorize('EDIT_' . $permissionKey);

        $item = $modelPath::findOrFail($id);

        $this->validateEditForm($request, $item);

        $item->update($request->all());

        $this->notify($resourceMultiple . '.edited');

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
        extract($this->getResourceNames());

        $this->authorize('EDIT_' . $permissionKey);

        $items = $modelPath::findOrFail($id);

        $items->delete();

        $this->notify($resourceMultiple . '.destroyed');

        return redirect()->route('reactor.' . $resourceMultiple . '.index');
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        extract($this->getResourceNames());

        $results = $modelPath::search($request->input('q'), 20, true)->get();

        return $this->compileView($resourceMultiple . '.search', [$resourceMultiple => $results]);
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        extract($this->getResourceNames());

        $this->authorize('EDIT_' . $permissionKey);

        $ids = json_decode($request->input('_bulkSelected', '[]'));

        $modelPath::whereIn('id', $ids)->delete();

        $this->notify($resourceMultiple . '.destroyed');

        return redirect()->route('reactor.' . $resourceMultiple . '.index');
    }

    /**
     * Returns necessary resource names
     *
     * @return array
     */
    protected function getResourceNames()
    {
        return [
            'modelPath'   => $this->modelPath,
            'resourceMultiple' => $this->resourceMultiple,
            'resourceSingular' => $this->resourceSingular,
            'permissionKey' => $this->permissionKey
        ];
    }

}