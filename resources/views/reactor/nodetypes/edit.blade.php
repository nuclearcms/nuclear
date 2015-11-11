@extends('layout.form')

@section('pageTitle', trans('nodes.edit_type'))
@section('contentSubtitle')
    {!! link_to_route('reactor.nodes.index', uppercase(trans('nodes.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $nodeType->label,
        'headerHint' => $nodeType->name
    ])

    <div class="material-light">
        @include('nodetypes.tabs', [
            'currentTab' => 'reactor.nodes.edit',
            'currentKey' => $nodeType->getKey()
        ])

        <div class="content-form">
            {!! form_rest($form) !!}
        </div>
    </div>

@endsection