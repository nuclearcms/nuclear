@extends('nodefields.base_edit')

@section('form_buttons')
    @can('EDIT_NODETYPES')
        {!! submit_button('icon-floppy') !!}
    @endcan
@endsection