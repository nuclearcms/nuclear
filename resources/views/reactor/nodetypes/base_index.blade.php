@extends('layout.content')

@section('actions')
    @include('partials.contents.search', ['key' => 'nodetypes'])
    @include('partials.contents.bulk', ['key' => 'nodetypes'])

    @can('EDIT_ROLES')
        {!! header_action_open('nodetypes.new', 'header__action--right') !!}
        {!! action_button(route('reactor.nodetypes.create'), 'icon-plus') !!}
        {!! header_action_close() !!}
    @endcan
@endsection