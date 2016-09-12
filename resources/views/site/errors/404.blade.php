@extends('errors.base')

@section('title', trans('errors.page_not_found'))
@section('code', '404')

@section('description')
    <p>{{ trans('errors.we_could_not_find_the_page') }}</p>
    {!! link_to_route('site.home', trans('errors.go_back_to_homepage')) !!}
@endsection