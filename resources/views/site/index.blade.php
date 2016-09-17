@extends('layout.site')

@include('partials.seo.metadata_node', ['node' => $home])

@section('content')
    <h1>{{ $home->getTranslationAttribute('meta_title') }}</h1>

    <div class="markdown-preview">
        {!! $home->content->synthesize() !!}
    </div>
@endsection