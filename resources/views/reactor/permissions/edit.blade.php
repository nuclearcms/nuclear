@extends('permissions.base_edit')

@section('form_buttons')
    @can('EDIT_PERMISSIONS')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection