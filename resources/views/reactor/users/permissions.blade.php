@extends('users.base_edit')
<?php $_withForm = false; ?>

@section('content')
    @include('users.tabs', [
        'currentRoute' => 'reactor.users.permissions',
        'currentKey' => $user->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('permissions.sublist', [
            'route' => route('reactor.users.permissions.revoke', $user->getKey())
        ])

        @if($count > 0)
        @include('permissions.add')
        @endif
    </div>
@endsection

@include('partials.modals.delete_specific', ['message' => trans('permissions.confirm_revoke')])