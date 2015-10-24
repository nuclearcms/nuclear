<?php

namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Reactor\Http\Requests;

class NodeTypesController extends ReactorController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * List the specified resource fields.
     *
     * @param int $id
     * @return Response
     */
    public function fields($id)
    {

    }

    /**
     * Add a field to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function addField(Request $request, $id)
    {

    }

    /**
     * Remove a field from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function removeField(Request $request, $id)
    {

    }

}
