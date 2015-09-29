<?php

namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Reactor\User;

class UsersController extends ReactorController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::sortable()->paginate();

        return view('users.index')
            ->with(compact('users'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $users = User::search($request->input('q'))->get();

        return view('users.search')
            ->with(compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        User::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        User::findOrFail($id);

        // Soft delete
    }
}
