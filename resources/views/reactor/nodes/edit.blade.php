@extends('nodes.base_edit')
<?php $_withForm = true; ?>

@section('tab_options')
    OPT
@endsection

@section('children_tabs')
    @include('partials.contents.tabs_translations', [
        'translatable' => $node,
        'translationRoute' => 'reactor.nodes.edit'
    ])
@endsection

@section('content')
    @include('nodes.tabs', [
        'currentRoute' => 'reactor.nodes.edit',
        'currentKey' => $node->getKey()
    ])

    <div class="content-inner">
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection

@section('form_buttons')
    @if($node->isLocked())
        {!! button('icon-lock', '', 'button', 'button--disabled') !!}
    @else
    @can('EDIT_NODES')
        {!! submit_button('icon-floppy') !!}
    @endcan
    @endif
@endsection