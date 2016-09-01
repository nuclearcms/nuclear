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

    <div class="content-inner content-inner--plain">
        <div class="content-inner__options{{ (locale_count() > 1) ? ' content-inner__options--displaced' : '' }}">
            @include('nodes.options', ['_edit' => true])
        </div>

        {!! form_start($form) !!}
        <div class="form-column form-column--primary">
            {!! form_rest($form) !!}
        </div>

        <div class="form-column form-column--secondary">
            @if($node->isTaggable())
                @include('partials.nodes.tags', ['tags' => $node->tags])
            @endif

            <div class="form-section">
                <h4 class="form-section__heading">{{ uppercase(trans('nodes.seo')) }}</h4>
                {{-- We had to do this separately since form_until included meta_title as well --}}
                {!! form_row($form->meta_title) !!}
                {!! form_row($form->meta_keywords) !!}
                {!! form_row($form->meta_description) !!}
                {!! form_row($form->meta_image) !!}
                {!! form_row($form->meta_author) !!}
            </div>
        </div>
        <div class="form-column-bg-secondary"></div>

        <div class="form-buttons" id="formButtons">
            @yield('form_buttons')
        </div>
        {!! form_end($form) !!}

    </div>
@endsection

@section('scripts')
    @parent
    {!! Theme::js('js/tags.js') !!}
    {!! Theme::js('js/uploader.js') !!}
    {!! Theme::js('js/nodesforms.js') !!}
@endsection

@section('modules')
    @parent

    @include('documents.library')

    {{-- THESE ONLY SHOULD BE ON NODES FORM BASE
    @include('modal.editor', ['containerClass' => 'modal--editor'])
    --}}
@endsection