@extends('partials.modals.base', [
    'containerClass' => 'modal--editor',
    'modalTitle' => '<span class="editor-modal__heading editor-modal__heading--link">' . trans('general.insert_link') . '</span><span class="editor-modal__heading editor-modal__heading--media">' . trans('general.insert_media') . '</span>'
])

@section('modalContent')
    <div class="editor-modal__dialog editor-modal__dialog--link">
        <div class="modal__message">{{ trans('general.enter_link_information') }}</div>

        {!! field_wrapper_open([], 'link_url', $errors, 'form-group--inverted') !!}
            {!! field_label(true, ['label' => trans('validation.attributes.url')], 'link_url', $errors) !!}
            {!! Form::text('link_url') !!}
        </div>

        {!! field_wrapper_open([], 'link_title', $errors, 'form-group--inverted') !!}
            {!! field_label(true, ['label' => trans('validation.attributes.title')], 'link_title', $errors) !!}
            {!! Form::text('link_title') !!}
        </div>

        {!! field_wrapper_open([], 'link_title', $errors, 'form-group--inverted') !!}
            <div class="form-group__label">{{ trans('general.open_in_new_window') }}</div>
            <label class="form-group__checkbox">
                <input type="checkbox" name="link_blank" value="1">
                <span>
                    <i class="form-group__checkbox-icon icon-cancel button__icon button__icon--right"> <span>{{ uppercase(trans('general.no')) }}</span></i><i class="form-group__checkbox-icon icon-confirm button__icon button__icon--right"> <span>{{ uppercase(trans('general.yes')) }}</span></i>
                </span>
            </label>
        </div>
    </div>
    <div class="editor-modal__dialog editor-modal__dialog--media">
        <div class="modal__message">{{ trans('general.insert_from_library') }}</div>

        <div class="modal__buttons">
            {!! button('icon-image', trans('documents.gallery'), 'button', 'button--emphasis button--gallery') !!}
            {!! button('icon-image', trans('documents.image_or_document'), 'button', 'button--emphasis button--document') !!}
        </div>

        <div class="modal__separator">{{ trans('general.or') }}</div>

        <div class="modal__message">{{ trans('general.enter_image_information') }}</div>
        {!! field_wrapper_open([], 'image_url', $errors, 'form-group--inverted') !!}
            {!! field_label(true, ['label' => trans('validation.attributes.url')], 'image_url', $errors) !!}
            {!! Form::text('image_url') !!}
        </div>

        {!! field_wrapper_open([], 'image_alttext', $errors, 'form-group--inverted') !!}
            {!! field_label(true, ['label' => trans('validation.attributes.alttext')], 'image_alttext', $errors) !!}
            {!! Form::text('image_alttext') !!}
        </div>
    </div>
@endsection

@section('modalButtons')
    <button class="button button--close">
        {{ uppercase(trans('general.dismiss')) }}
    </button>
    <button class="button button--emphasis button--confirm">
        {{ uppercase(trans('general.insert')) }}
    </button>
@endsection