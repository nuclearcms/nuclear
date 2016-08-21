@extends('nodetypes.base_edit')
<?php $_withForm = true; ?>

@section('content')
    @include('nodetypes.tabs', [
        'currentRoute' => 'reactor.nodetypes.edit',
        'currentKey' => $nodetype->getKey()
    ])

    <div class="content-inner">
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection

@section('form_buttons')
    @can('EDIT_NODETYPES')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection