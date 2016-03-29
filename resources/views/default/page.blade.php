@extends('layout.site')

@section('pageTitle', $node->title)

@section('content')
    <div class="content">
        {!! Synthesizer::HTMLmarkdown($node->content) !!}
    </div>
@endsection