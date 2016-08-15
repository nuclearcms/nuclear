@extends('roles.base_edit')

@section('content')
    @include('roles.tabs', [
        'currentRoute' => 'reactor.roles.permissions',
        'currentKey' => $role->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('permissions.sublist', [
            'route' => route('reactor.roles.permissions.revoke', $role->getKey())
        ])

        @if($count > 0)
        @include('permissions.add')
        @endif
    </div>
@endsection

@include('partials.modals.delete', ['message' => trans('permissions.confirm_revoke')])