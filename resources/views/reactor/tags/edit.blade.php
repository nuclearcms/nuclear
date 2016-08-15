@extends('tags.base_edit')

@section('content')
    @section('children_tabs')
        @include('partials.contents.tabs_translations', [
            'translatable' => $tag,
            'translationRoute' => 'reactor.tags.edit',
            'translateRoute' => 'reactor.tags.translations.create'
        ])
    @endsection

    @include('tags.tabs', [
        'currentRoute' => 'reactor.tags.edit',
        'currentKey' => [$tag->getKey(), $translation->getKey()]
    ])

    @parent
@endsection

@section('form_buttons')
    @can('EDIT_USERS')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection