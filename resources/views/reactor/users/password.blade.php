@extends('users.base_edit')

@section('content')
    @include('users.tabs', [
        'currentRoute' => 'reactor.users.password',
        'currentKey' => $profile->getKey()
    ])
    @parent
@endsection

@section('form_buttons')
    @can('EDIT_USERS')
    {!! submit_button('icon-lock') !!}
    @endcan
@endsection