@extends('documents.base_edit')
<?php $_withForm = false; ?>

@section('pageSubtitle')
    {!! link_to_route('reactor.documents.edit', uppercase($document->name), $document->getKey()) !!}
@endsection

@section('content')
    <div id="imageEditor" class="image-editor form-column form-column--full">

        <ul class="image-editor__toolbar">
            <li><button title="{{ trans('documents.tool_crop') }}" id="toolCrop" class="button button--disabled-plain"><i class="image-editor__icon icon-crop"></i></button></li>
            <li><button title="{{ trans('documents.tool_rotate_ccw') }}" id="toolRotateCCW" class="button"><i class="image-editor__icon icon-ccw"></i></button></li>
            <li><button title="{{ trans('documents.tool_rotate_cw') }}" id="toolRotateCW" class="button"><i class="image-editor__icon icon-cw"></i></button></li>
            <li><button title="{{ trans('documents.tool_flip_horizontal') }}" id="toolFlipHorizontal" class="button"><i class="image-editor__icon icon-flip-horizontal"></i></button></li>
            <li><button title="{{ trans('documents.tool_flip_vertical') }}" id="toolFlipVertical" class="button"><i class="image-editor__icon icon-flip-vertical"></i></button></li>
            <li><button title="{{ trans('documents.tool_grayscale') }}" id="toolGrayscale" class="button"><i class="image-editor__icon icon-checkerboard"></i></button></li>
            <li><button title="{{ trans('documents.tool_sharpen') }}" id="toolSharpen" class="button"><i class="image-editor__icon icon-sharpen"></i></button></li>
            <li><button title="{{ trans('documents.tool_blur') }}" id="toolBlur" class="button"><i class="image-editor__icon icon-blur"></i></button></li>
        </ul>

        <div class="image-editor__frame">
            <img src="{{ $document->getPublicURL() }}" class="image-editor__image">
        </div>

        {!! form($form) !!}
    </div>
@endsection

@section('scripts')
    {!! Theme::js('js/image.js') !!}
@endsection