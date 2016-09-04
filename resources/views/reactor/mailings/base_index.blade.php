@extends('layout.content')

@section('actions')
    @include('partials.contents.search', ['key' => 'mailings'])
    @include('partials.contents.bulk', ['key' => 'mailings'])

    @can('EDIT_MAILINGS')
        {!! header_action_open('mailings.new', 'header__action--right') !!}
        {!! action_button(route('reactor.mailings.create'), 'icon-plus') !!}
        {!! header_action_close() !!}
    @endcan
@endsection