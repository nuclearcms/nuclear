@extends('users.base_edit')

@section('form_buttons')
    @can('EDIT_USERS')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection

@section('content')
    @include('users.tabs', [
        'currentRoute' => 'reactor.users.edit',
        'currentKey' => $user->getKey()
    ])
    @parent
@endsection