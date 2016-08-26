@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.nodetypes.fields', uppercase(trans($nodetype->getTitle())), $nodetype->getKey()) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $nodetype->label,
        'headerHint' => $nodetype->name
    ])
@endsection

@section('content')
    @include('partials.contents.form')
@endsection