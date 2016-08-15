@extends('layout.reactor')

@section('actions')
    @include('partials.contents.search', ['key' => 'tags'])
    @include('partials.contents.bulk', ['key' => 'tags'])

    @can('EDIT_TAGS')
        {!! header_action_open('tags.new', 'header__action--right') !!}
        {!! action_button(route('reactor.tags.create'), 'icon-tag-create') !!}
        {!! header_action_close() !!}
    @endcan
@endsection

@include('partials.modals.delete')