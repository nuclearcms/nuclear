@extends('layout.content')

@section('actions')
    @include('partials.contents.search', ['key' => 'permissions'])
    @include('partials.contents.bulk', ['key' => 'permissions'])

    @can('EDIT_PERMISSIONS')
        {!! header_action_open('permissions.new', 'header__action--right') !!}
        {!! action_button(route('reactor.permissions.create'), 'icon-plus') !!}
        {!! header_action_close() !!}
    @endcan
@endsection