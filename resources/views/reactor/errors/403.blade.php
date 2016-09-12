@extends('errors.base')

@section('title', trans('errors.not_authorized'))
@section('code', '403')

@section('description')
    <p>{{ trans('errors.you_are_not_authorized') }}</p>
    {!! link_to_route('reactor.dashboard', trans('errors.go_back_to_dashboard')) !!}
@endsection