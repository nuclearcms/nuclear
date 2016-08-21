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
    <div class="content-inner">
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection