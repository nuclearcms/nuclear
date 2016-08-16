@extends('tags.base_index')

@section('pageSubtitle')
    {!! link_to_route('reactor.tags.index', uppercase(trans('tags.title'))) !!}
@endsection

@section('content')
    <div class="tags-list-container">
        @include('tags.list')
    </div>

    <div class="content-footer">
        {!! action_button(route('reactor.tags.index'), 'icon-arrow-left', trans('tags.all'), '', 'l') !!}
    </div>
@endsection