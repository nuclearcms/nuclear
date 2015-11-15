@extends('layout.form')

@section('pageTitle', trans('nodes.parameters'))
@section('contentSubtitle')
    {{ uppercase(trans('nodes.title')) }}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $node->title,
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