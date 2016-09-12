@extends('errors.base')

@section('title', trans('errors.reactor_meltdown'))

@section('image')
    {!! Theme::img('img/meltdown-logo.svg', 'Meltdown Logo') !!}
@endsection

@section('description')
    <p>{!! trans('errors.nobody_died') !!}</p>
@endsection