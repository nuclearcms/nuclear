@extends('nodetypes.base_edit')
<?php $_withForm = true; ?>

@section('form_buttons')
    @can('EDIT_NODETYPES')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection

@section('content')
    @include('nodetypes.tabs', [
        'currentRoute' => 'reactor.nodetypes.edit',
        'currentKey' => $nodetype->getKey()
    ])

    @include('partials.contents.form')
@endsection