{!! field_wrapper_open($options, $name, $errors, 'form-group-document') !!}

<div class="form-group-column form-group-column-field">
    {!! field_label($showLabel, $options, $name) !!}

    @if($document = get_document($options['value']))
    <div class="form-media-container">
        <div class="form-document-thumbnail material-light">
            {!! $document->present()->thumbnail !!}<p>
                {{ $document->name }}
            </p>
    @else
    <div class="form-media-container empty">
        <div class="form-document-thumbnail material-light">
            <img src="">
    @endif
        </div>
        <div class="empty-notification">
            {{ trans('documents.no_media_selected') }}
        </div>
        <div class="buttons">
            {!! button('icon-trash', trans('general.clear'), 'button', 'button-clear') !!}{!!
            button('icon-picture', trans('general.add_or_change'), 'button', 'button-add') !!}
        </div>
        {!! Form::hidden($name, $options['value'], $options['attr']) !!}
    </div>

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}