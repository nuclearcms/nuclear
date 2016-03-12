@extends('layout.form')

@section('pageTitle', trans('tags.add_translation'))
@section('contentSubtitle')
    {!! link_to_route('reactor.tags.edit', uppercase($translation->name), [$tag->getKey(), $translation->getKey()]) !!}
@endsection

@section('action')
    {!! submit_button('icon-list-add') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $translation->name,
        'headerHint' => $translation->slug
    ])

    <div class="material-light content-form">
        {!! form_rest($form) !!}
    </div>

@endsection