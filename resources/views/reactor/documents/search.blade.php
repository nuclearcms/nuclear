@extends('documents.base_index')

@section('pageSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('actions')
    @parent
    <?php $filterSearch = true; ?>
@endsection

@section('content')
    <div class="documents-list-container">
        @include('documents.list')
    </div>

    <div class="content-footer">
        {!! action_button(route('reactor.documents.index'), 'icon-arrow-left', trans('documents.all'), '', 'l') !!}
    </div>
@endsection