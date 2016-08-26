@extends('layout.form')

@section('pageSubtitle')
    {!! ($parent)
    ? link_to($parent->getDefaultEditUrl(), uppercase($parent->getTitle()))
    : uppercase(trans('nodes.title')) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection