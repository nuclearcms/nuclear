@extends('nodes.base_edit')
<?php $_withForm = true; ?>

@section('content')
    @include('nodes.tabs', [
        'currentRoute' => 'reactor.nodes.parameters.edit',
        'currentKey' => $node->getKey()
    ])

    <div class="content-inner">
        <div class="content-inner__options">
            @include('nodes.options')
        </div>
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection

@section('form_buttons')
    @can('EDIT_NODES')
        {!! submit_button('icon-floppy') !!}
    @endcan
@endsection