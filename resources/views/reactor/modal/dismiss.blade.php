@extends('modal.base')

@section('modalButtons')
    <button class="button close-button">
        {{ uppercase(trans('general.dismiss')) }}
    </button>
@endsection