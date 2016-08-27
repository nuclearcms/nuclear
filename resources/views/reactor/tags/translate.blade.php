@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.tags.edit', uppercase($translation->title), [$tag->getKey(), $translation->getKey()]) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $tag->title,
        'headerHint' => $tag->tag_name
    ])
@endsection

@section('form_buttons')
    {!! submit_button('icon-language') !!}
@endsection

@section('content')
    @include('partials.contents.form')
@endsection