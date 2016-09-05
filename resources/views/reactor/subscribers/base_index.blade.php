@extends('layout.content')

@section('actions')
    @include('partials.contents.search', ['key' => 'subscribers'])
    @include('partials.contents.bulk', ['key' => 'subscribers'])

    @can('EDIT_SUBSCRIBERS')
        {!! header_action_open('subscribers.new', 'header__action--right') !!}
        {!! action_button(route('reactor.subscribers.create'), 'icon-plus') !!}
        {!! header_action_close() !!}
    @endcan
@endsection