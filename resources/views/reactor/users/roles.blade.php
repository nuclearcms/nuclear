@extends('users.base_edit')
<?php $_withForm = false; ?>

@section('content')
    @include('users.tabs', [
        'currentRoute' => 'reactor.users.roles',
        'currentKey' => $profile->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('roles.sublist', ['roles' => $profile->roles])

        @if($count > 0)
        @include('roles.add')
        @endif
    </div>
@endsection

@include('partials.modals.delete', ['message' => trans('roles.confirm_dissociate')])