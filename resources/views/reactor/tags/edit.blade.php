@extends('layout.form')

@section('pageTitle', trans('tags.edit'))
@section('contentSubtitle')
    {!! link_to_route('reactor.tags.index', uppercase(trans('tags.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $translation->name,
        'headerHint' => $translation->slug
    ])

    <div class="material-light">
        @include('tags.tabs', [
            'currentTab' => 'reactor.tags.edit',
            'currentKey' => $tag->getKey()
        ])

        @include('tags.translationtabs', [
            'route' => 'reactor.tags.edit',
            'currentTranslation' => $translation
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection