@extends('layout.form')

@section('pageTitle', ($parent) ? trans('nodes.add_child') : trans('nodes.create'))
@section('contentSubtitle', ($parent) ?  link_to_route('reactor.nodes.edit', uppercase($parent->title), $parent->getKey()): uppercase(trans('nodes.title')))

@section('action')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>
@endsection