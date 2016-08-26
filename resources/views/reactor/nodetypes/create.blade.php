@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.nodetypes.index', uppercase(trans('nodetypes.title'))) !!}
@endsection

@section('form_buttons')
    {!! submit_button('icon-plus') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection