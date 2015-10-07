@extends('modal.base')

@section('modalButtons')
    <button class="button close-button">
        {{ uppercase(trans('general.dismiss')) }}
    </button>
    <button class="button button-emphasized confirm-button">
        {{ uppercase(trans('general.confirm')) }}
    </button>
@endsection