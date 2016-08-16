@extends('tags.base_index')

@section('pageSubtitle', uppercase(trans('tags.title')))

@section('content')
    <div class="tags-list-container">
        <div class="sortable-links">
            {!! sortable_link('title', uppercase(trans('validation.attributes.title'))) !!} {!! sortable_link('created_at', uppercase(trans('validation.attributes.created_at'))) !!}
        </div>

        @include('tags.list')
    </div>

    <div class="content-footer">
        @include('partials.contents.pagination', ['paginator' => $tags, 'paginationModifier' => 'pagination--inpage'])
    </div>
@endsection