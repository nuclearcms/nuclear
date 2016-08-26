@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.permissions.index', uppercase(trans('permissions.title'))) !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection