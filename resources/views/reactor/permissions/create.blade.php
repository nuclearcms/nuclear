@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.permissions.index', uppercase(trans('permissions.title'))) !!}
@endsection

@section('content')
    <div class="content-form">

        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>

    </div>
@endsection

@section('form_buttons')
    @can('EDIT_PERMISSIONS')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection