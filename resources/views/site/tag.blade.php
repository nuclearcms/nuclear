@extends('layout.site')

@section('pageTitle', trans('tags.self') . ': ' . $tag->translate(null, true)->title)

@section('content')
    <h1>@yield('pageTitle')</h1>
@endsection