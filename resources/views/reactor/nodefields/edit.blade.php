@extends('layout.form')

@section('pageTitle', trans('nodes.edit_type'))
@section('contentSubtitle')
    {!! link_to_route('reactor.nodes.fields', uppercase($nodeField->nodeType->label), ['id' => $nodeField->nodeType->getKey()]) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $nodeField->label,
        'headerHint' => $nodeField->name
    ])

    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>

@endsection