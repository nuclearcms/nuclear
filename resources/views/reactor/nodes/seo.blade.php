@extends('nodes.form')

@section('pageTitle', trans('nodes.seo'))
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
        'headerTitle' => $source->title,
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