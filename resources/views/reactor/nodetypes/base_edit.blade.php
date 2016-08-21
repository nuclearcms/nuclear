@extends('layout.' . ((isset($_withForm) && $_withForm === true) ? 'form' : 'content'))

@section('pageSubtitle')
    {!! link_to_route('reactor.nodetypes.index', uppercase(trans('nodetypes.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $nodetype->label,
        'headerHint' => $nodetype->name
    ])
@endsection