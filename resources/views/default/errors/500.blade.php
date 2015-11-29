@extends('errors.base')

@section('title', trans('errors.server_error'))

@section('code', 500)
@section('description')
    <p>{!! trans('errors.nobody_died') !!}</p>
@endsection