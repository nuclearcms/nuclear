@extends('nodes.base_edit')
<?php $_withForm = true; ?>

@section('pageSubtitle')
    {!! link_to($node->getDefaultEditUrl(), uppercase($node->getTitle())) !!}
@endsection

@section('form_buttons')
    @can('EDIT_NODES')
    {!! submit_button('icon-blank') !!}
    @endcan
@endsection

@section('content')
    @include('partials.contents.form')
@endsection