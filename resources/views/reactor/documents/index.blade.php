@extends('documents.base_index')

@section('pageSubtitle', uppercase(trans('documents.title')))

@section('content')
    <div class="documents-list-container">
        <div class="sortable-links">
            {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!} {!! sortable_link('created_at', uppercase(trans('validation.attributes.created_at'))) !!} {!! sortable_link('updated_at', uppercase(trans('validation.attributes.updated_at'))) !!}
        </div>

        @include('documents.list')
    </div>

    <div class="content-footer">
        @include('partials.contents.pagination', ['paginator' => $documents, 'paginationModifier' => 'pagination--inpage'])
    </div>
@endsection