@extends('layout.site')

@section('pageTitle', $home->title)

@section('content')
    <div class="content">
        {!! Synthesizer::markdown($home->content) !!}
    </div>
@endsection