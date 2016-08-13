@extends('roles.base_edit')
<?php $_withForm = false; ?>

@section('content')
    @include('roles.tabs', [
        'currentRoute' => 'reactor.roles.permissions',
        'currentKey' => $model->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('permissions.sublist', [
            'route' => route('reactor.roles.permission.revoke', $model->getKey())
        ])

        ADD THE SUB FORM HERE
    </div>
@endsection

@include('partials.modals.delete', ['message' => trans('permissions.confirm_revoke')])