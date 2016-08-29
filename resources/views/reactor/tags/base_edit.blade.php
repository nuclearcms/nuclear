@extends('layout.' . ((isset($_withForm) && $_withForm === false) ? 'reactor' : 'form'))

@section('pageSubtitle')
    {!! link_to_route('reactor.tags.index', uppercase(trans('tags.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $tag->title,
        'headerHint' => $tag->tag_name
    ])
@endsection