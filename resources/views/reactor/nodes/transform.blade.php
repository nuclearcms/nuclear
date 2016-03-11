@extends('layout.form')

@section('pageTitle', trans('nodes.transform'))
@section('contentSubtitle')
    {!! link_to_route('reactor.contents.edit', uppercase($source->title), [$node->getKey(), $source->getKey()]) !!}
@endsection

@section('action')
    {!! submit_button('icon-exchange') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $source->title,
        'headerHint' => $node->nodeType->label
    ])

    <div class="material-light content-form">
        {!! form_rest($form) !!}
    </div>

@endsection