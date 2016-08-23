@extends('layout.content')

@section('actions')
    @include('partials.contents.search', ['key' => 'roles'])
    @include('partials.contents.bulk', ['key' => 'roles'])

    @can('EDIT_ROLES')
        {!! header_action_open('roles.new', 'header__action--right') !!}
        {!! action_button(route('reactor.roles.create'), 'icon-plus') !!}
        {!! header_action_close() !!}
    @endcan
@endsection