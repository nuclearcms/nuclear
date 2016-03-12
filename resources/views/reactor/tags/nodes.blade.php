@extends('layout.reactor')

@section('pageTitle', trans('nodes.title'))
@section('contentSubtitle')
    {!! link_to_route('reactor.tags.index', uppercase(trans('tags.title'))) !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $translation->name,
        'headerHint' => $translation->slug
    ])

    <div class="material-light">
        @include('tags.tabs', [
            'currentTab' => 'reactor.tags.nodes',
            'currentKey' => $tag->getKey()
        ])

        @include('nodes.subtable')
    </div>

@endsection

@include('partials.content.delete_modal', ['message' => 'nodes.confirm_delete'])