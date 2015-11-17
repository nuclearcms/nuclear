@extends('layout.form')

@section('pageTitle', trans('nodes.add_translation'))
@section('contentSubtitle')
    {!! link_to_route('reactor.contents.edit', uppercase($node->title), $node->getKey()) !!}
@endsection

@section('action')
    {!! submit_button('icon-list-add') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $node->title,
        'headerHint' => $node->nodeType->label
    ])

    <div class="material-light content-form">
        {!! form_rest($form) !!}
    </div>

@endsection