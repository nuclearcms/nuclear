@extends('roles.base_edit')
<?php $_withForm = true; ?>

@section('content')
    @include('roles.tabs', [
        'currentRoute' => 'reactor.roles.edit',
        'currentKey' => $role->getKey()
    ])

    <div class="content-inner">
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection

@section('form_buttons')
    @can('EDIT_ROLES')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection