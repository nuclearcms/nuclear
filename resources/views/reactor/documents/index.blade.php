@extends('layout.reactor')

@section('pageTitle', trans('documents.manage'))
@section('contentSubtitle', uppercase(trans('documents.title')))


@section('action')
    @can('ACCESS_DOCUMENTS_UPLOAD')
        {!! action_button(route('reactor.documents.upload'), 'icon-upload-cloud') !!}
        {!! action_button(route('reactor.documents.embed'), 'icon-code', true) !!}
    @endcan
@endsection


@section('content')
    <div class="content-options">
        @include('partials.content.search', ['placeholder' => trans('documents.search')])
    </div>

    @include('documents.content')

    <div class="content-footer">
        @include('partials.pagination', ['pagination' => $documents])
    </div>
@endsection

@include('partials.content.delete_modal', ['message' => 'documents.confirm_delete'])