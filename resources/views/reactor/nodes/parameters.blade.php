@extends('nodes.base_edit')
<?php $_withForm = true; ?>

@section('form_buttons')
    {!! submit_button('icon-floppy') !!}
@endsection

@section('content')
    @include('nodes.tabs', [
        'currentRoute' => 'reactor.nodes.parameters.edit',
        'currentKey' => $node->getKey()
    ])

    <div class="content-inner">
        <div class="content-inner__options">
            @include('nodes.options')
        </div>

        {!! form_start($form) !!}
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>

        <div class="form-buttons" id="formButtons">
            @yield('form_buttons')
        </div>
        {!! form_end($form) !!}

    </div>
@endsection