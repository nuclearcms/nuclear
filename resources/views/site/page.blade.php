@extends('layout.site')

<?php $isNode = true; ?>
@include('partials.seo.metadata_node')

@section('content')
    <h1>@yield('pageTitle')</h1>

    <div class="markdown-preview">
        {!! $node->content->synthesize() !!}
    </div>
@endsection