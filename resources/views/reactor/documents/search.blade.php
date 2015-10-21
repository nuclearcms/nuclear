@extends('layout.content')

@section('pageTitle', trans('documents.search'))
@section('contentSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('content')
    <div class="content-options">
        @include('partials.content.bigsearch', ['result_count' => $documents->count()])
    </div>

    @if($documents->count())
        @include('documents.content')
    @else
        {!! no_results_row() !!}
    @endif

    <div class="content-footer">
        {!! back_to_all_link(route('reactor.documents.index'), 'documents.all') !!}
    </div>
@endsection

@include('partials.content.delete_modal', ['message' => 'users.confirm_delete_permission'])