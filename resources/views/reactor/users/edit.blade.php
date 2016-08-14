@extends('users.base_edit')

@section('content')
    @include('users.tabs', [
        'currentRoute' => 'reactor.users.edit',
        'currentKey' => $profile->getKey()
    ])
    @parent
@endsection

@section('form_buttons')
    @can('EDIT_USERS')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection