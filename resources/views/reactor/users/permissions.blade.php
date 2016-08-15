@extends('users.base_edit')
<?php $_withForm = false; ?>

@section('content')
    @include('users.tabs', [
        'currentRoute' => 'reactor.users.permissions',
        'currentKey' => $profile->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('permissions.sublist', [
            'route' => route('reactor.users.permissions.revoke', $profile->getKey())
        ])

        @if($count > 0)
            @include('permissions.add')
        @endif
    </div>
@endsection

@include('partials.modals.delete', ['message' => trans('permissions.confirm_revoke')])