@extends('layout.site')

@section('pageTitle', $node->title)

@section('content')
    <div class="content">
        {!! Synthesizer::markdown($node->content) !!}
    </div>
@endsection