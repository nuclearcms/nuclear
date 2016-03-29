@extends('layout.site')

@section('pageTitle', $home->title)

@section('content')
    <div class="content">
        {!! Synthesizer::HTMLmarkdownBefore($home->content) !!}
    </div>
@endsection