@extends('errors.base')

@section('title', trans('errors.be_right_back'))
@section('code', '503')

@section('description')
    <p>{{ trans('errors.maintenance') }}</p>
@endsection