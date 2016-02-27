@extends('layout.form')

@section('pageTitle', trans('nodes.edit'))
@section('contentSubtitle')
    {{ uppercase(trans('nodes.title')) }}
@endsection

@section('action')
    @unless($node->isLocked())
        {!! submit_button('icon-floppy') !!}

        @unless($node->isPublished())
            {!! submit_button('icon-publish', '', 'button-secondary publish-save') !!}
        @endunless
    @else
        {!! button('icon-lock', '', 'button', 'button-disabled') !!}
    @endunless
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
            'currentTab' => 'reactor.contents.edit',
            'currentKey' => $node->getKey()
        ])

        @include('nodes.translationtabs', [
            'route' => 'reactor.contents.edit'
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>

@endsection