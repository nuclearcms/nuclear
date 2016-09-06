@extends('mailings.base_edit')
<?php $_withForm = true; ?>

@section('form_buttons')
    @can('EDIT_MAILINGS')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection

@section('content')
    @include('mailings.tabs', [
        'currentRoute' => 'reactor.mailings.edit',
        'currentKey' => $mailing->getKey()
    ])


    <div class="content-inner">
        <div class="content-inner__options">
            @include('mailings.options')
        </div>

        {!! form_start($form) !!}
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
        {!! form_end($form) !!}

        <div class="form-buttons" id="formButtons">
            @yield('form_buttons')
        </div>
    </div>
@endsection

@include('layout.full_form')