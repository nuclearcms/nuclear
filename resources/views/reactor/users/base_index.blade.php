@extends('layout.content')

@section('actions')
    @include('partials.contents.search', ['key' => 'users'])
    @include('partials.contents.bulk', ['key' => 'users'])

    @can('EDIT_USERS')
        {!! header_action_open('users.new', 'header__action--right') !!}
        {!! action_button(route('reactor.users.create'), 'icon-user-create') !!}
        {!! header_action_close() !!}
    @endcan
@endsection