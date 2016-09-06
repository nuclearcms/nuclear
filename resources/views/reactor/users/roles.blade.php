@extends('users.base_edit')
<?php $_withForm = false; ?>

@section('content')
    @include('users.tabs', [
        'currentRoute' => 'reactor.users.roles',
        'currentKey' => $user->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('roles.sublist', ['roles' => $user->roles])

        @if($count > 0)
        @include('roles.add')
        @endif
    </div>
@endsection

@include('partials.modals.delete_specific', ['message' => trans('roles.confirm_dissociate')])