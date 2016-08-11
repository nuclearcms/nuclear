@extends('partials.modals.base')

@section('modalButtons')
    <button class="button button--close">
        {{ uppercase(trans('general.dismiss')) }}
    </button>
@endsection