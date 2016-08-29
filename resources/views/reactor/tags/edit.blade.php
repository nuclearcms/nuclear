@extends('tags.base_edit')

@section('children_tabs')
    @include('partials.contents.tabs_translations', [
        'translatable' => $tag,
        'translationRoute' => 'reactor.tags.edit',
        'translateRoute' => 'reactor.tags.translations.create'
    ])
@endsection

@section('form_buttons')
    @can('EDIT_TAGS')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection

@section('content')
    @include('tags.tabs', [
        'currentRoute' => 'reactor.tags.edit',
        'currentKey' => [$tag->getKey(), $translation->getKey()]
    ])

    @include('partials.contents.form')
@endsection