@extends('roles.base_edit')

@section('content')
    @include('roles.tabs', [
        'currentRoute' => 'reactor.roles.edit',
        'currentKey' => $role->getKey()
    ])
    @parent
@endsection

@section('form_buttons')
    @can('EDIT_ROLES')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection