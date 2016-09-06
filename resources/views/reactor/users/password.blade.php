@extends('users.base_edit')

@section('form_buttons')
    @can('EDIT_USERS')
    {!! submit_button('icon-lock') !!}
    @endcan
@endsection

@section('content')
    @include('users.tabs', [
        'currentRoute' => 'reactor.users.password',
        'currentKey' => $user->getKey()
    ])
    @parent
@endsection