@extends('nodes.base_edit')
<?php $_withForm = true; ?>

@section('pageSubtitle')
    {!! link_to($node->getDefaultEditUrl(), uppercase($node->getTitle())) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-language') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection