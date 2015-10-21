@extends('layout.reactor')

@section('pageTitle', trans('documents.manage'))
@section('contentSubtitle', uppercase(trans('documents.title')))

@can('ACCESS_DOCUMENTS_UPLOAD')
@section('action')
    {!! action_button(route('reactor.documents.upload'), 'icon-upload-cloud') !!}
@endsection
@endcan

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