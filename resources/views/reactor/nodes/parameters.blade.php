@extends('nodes.form')

@section('pageTitle', trans('nodes.parameters'))
@section('contentSubtitle')
    {{ uppercase(trans('nodes.title')) }}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}

    @unless($node->isPublished())
        {!! submit_button('icon-publish', '', 'button-secondary publish-save') !!}
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
            'currentTab' => 'reactor.contents.parameters',
            'currentKey' => $node->getKey()
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>

@endsection