@extends('modal.confirm')

@section('modalContent')
    <div class="node-option-message node">
        {{ trans('nodes.confirm_delete') }}
    </div>
    <div class="node-option-message translation">
        {{ trans('nodes.confirm_delete_translation') }}
    </div>
@endsection