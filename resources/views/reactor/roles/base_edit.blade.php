@extends('layout.' . ((isset($_withForm) && $_withForm === true) ? 'form' : 'content'))

@section('pageSubtitle')
    {!! link_to_route('reactor.roles.index', uppercase(trans('roles.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $role->label,
        'headerHint' => $role->name
    ])
@endsection