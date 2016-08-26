@extends('nodes.base_edit')
<?php $_withForm = true; ?>

@section('children_tabs')
    @include('partials.contents.tabs_translations', [
        'translatable' => $node,
        'translationRoute' => 'reactor.nodes.edit'
    ])
@endsection

@section('form_buttons')
    @if($node->isLocked())
        {!! button('icon-lock', '', 'button', 'button--disabled') !!}
    @else
        @can('EDIT_NODES')
            @if( ! $node->isPublished()){!!
        button('icon-status-published', '', 'button', 'button--action button--publisher')
        !!}@endif{!! submit_button('icon-floppy') !!}
        @endcan
    @endif
@endsection

@section('content')
    @include('nodes.tabs', [
        'currentRoute' => 'reactor.nodes.edit',
        'currentKey' => $node->getKey()
    ])

    <div class="content-inner{{ (locale_count() > 1) ? ' content-inner--xcompact' : '' }}">
        <div class="content-inner__options{{ (locale_count() > 1) ? ' content-inner__options--displaced' : '' }}">
            @include('nodes.options')
        </div>
        WHAT HAPPENS WHEN THE COLUMNS ARE HERE<br>
        ESPECIALLY WITH THE OPTION MENU WHEN THERE IS A SINGLE LOCALE

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