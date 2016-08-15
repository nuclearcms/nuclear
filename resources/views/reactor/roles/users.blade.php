@extends('roles.base_edit')

@section('content')
    @include('roles.tabs', [
        'currentRoute' => 'reactor.roles.users',
        'currentKey' => $role->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('users.sublist', ['users' => $role->users])

        @if($count > 0)
        @include('users.add')
        @endif
    </div>
@endsection

@include('partials.modals.delete', ['message' => trans('users.confirm_dissociate')])