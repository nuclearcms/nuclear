@extends('layout.site')

@include('partials.seo.metadata_node')

@section('content')
    <h1>@yield('pageTitle')</h1>

    <div class="markdown-preview">
        {!! $node->content->synthesize() !!}
    </div>
@endsection