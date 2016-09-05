@extends('layout.content')

@section('actions')
    @include('partials.contents.search', ['key' => 'mailing_lists'])
    @include('partials.contents.bulk', ['key' => 'mailing_lists'])

    @can('EDIT_MAILINGLISTS')
        {!! header_action_open('mailing_lists.new', 'header__action--right') !!}
        {!! action_button(route('reactor.mailing_lists.create'), 'icon-plus') !!}
        {!! header_action_close() !!}
    @endcan
@endsection