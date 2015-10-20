@extends('layout.reactor')

@section('pageTitle', trans('documents.manage'))
@section('contentSubtitle', uppercase(trans('documents.title')))

@can('ACCESS_DOCUMENTS_UPLOAD')
@section('action')
    {!! action_button(route('reactor.documents.upload'), 'icon-upload-cloud') !!}
@endsection
@endcan

@section('content_options')
    @include('partials.content.search', ['placeholder' => trans('documents.search')])
@endsection

@section('content_footer')
    @include('partials.pagination', ['pagination' => $documents])
@endsection

@include('partials.content.delete_modal', ['message' => 'documents.confirm_delete'])