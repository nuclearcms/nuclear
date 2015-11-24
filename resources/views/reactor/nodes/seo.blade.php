@extends('layout.form')

@section('pageTitle', trans('nodes.seo'))
@section('contentSubtitle')
    {{ uppercase(trans('nodes.title')) }}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.nodes.ancestors', [
        'ancestors' => $node->getAncestors()
    ])

    @include('partials.content.header', [
        'headerTitle' => $node->title,
        'headerHint' => $node->nodeType->label
    ])

    <div class="material-light">
        @include('nodes.tabs', [
            'currentTab' => 'reactor.contents.seo',
            'currentKey' => $node->getKey()
        ])

        @include('nodes.translationtabs', [
            'route' => 'reactor.contents.seo'
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>

@endsection