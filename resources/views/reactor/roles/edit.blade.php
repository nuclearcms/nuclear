@extends('roles.base_edit')
<?php $_withForm = true; ?>

@section('form_buttons')
    @can('EDIT_ROLES')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection

@section('content')
    @include('roles.tabs', [
        'currentRoute' => 'reactor.roles.edit',
        'currentKey' => $role->getKey()
    ])

    @include('partials.contents.form')
@endsection