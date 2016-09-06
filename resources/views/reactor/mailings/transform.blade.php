@extends('mailings.base_edit')
<?php $_withForm = true; ?>

@section('pageSubtitle')
    {!! link_to($mailing->getDefaultEditUrl(), uppercase($mailing->translateOrFirst()->title)) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-node-transform') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection