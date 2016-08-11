@extends('partials.modals.base')

@section('modalButtons')
    <button class="button button--close">
        {{ uppercase(trans('general.dismiss')) }}
    </button>
    <button class="button button--emphasis button--confirm">
        {{ uppercase(trans('general.confirm')) }}
    </button>
@endsection