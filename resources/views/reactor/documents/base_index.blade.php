@extends('layout.reactor')

@section('actions')
    @include('partials.contents.search', ['key' => 'documents'])

    @include('partials.contents.filter', [
        'filterTypes' => ['all', 'audio', 'document', 'image', 'video', 'embedded'],
        'defaultFilter' => 'all',
        'key' => 'documents',
        'filterSearch' => isset($filterSearch) ? $filterSearch : false
    ])

    @include('partials.contents.bulk', ['key' => 'documents'])

    @can('EDIT_DOCUMENTS')
        {!! header_action_open('documents.new', 'header__action--right') !!}
        {!! action_button(route('reactor.documents.embed'), 'icon-document-embed', '', 'button--action') !!}{!!
        action_button(route('reactor.documents.upload'), 'icon-document-upload') !!}
        {!! header_action_close() !!}
    @endcan
@endsection