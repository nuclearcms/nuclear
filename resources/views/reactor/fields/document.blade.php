{!! field_wrapper_open($options, $name, $errors, 'form-group--document') !!}

<div class="form-group-column form-group-column--{{ array_get($options, 'fullWidth', false) ? 'full' : 'field' }} ">
    {!! field_label($showLabel, $options, $name, $errors) !!}

    <div class="form-group__document-container {{ ($document = get_nuclear_documents($options['value'])) ? '' : ' empty' }}" data-filter="{{ array_get($options, 'filter', 'all') }}">
        @if($document)
        <figure class="form-group__document" data-id="{{ $document->getKey() }}" data-type="{{ $document->type }}" data-summary="{{ $document->summarize(true) }}">
            <span>{!! $document->present()->thumbnail !!}</span> <figcaption class="form-group__document-title">{{ $document->name }}</figcaption>
        </figure>
        @endif

        <div class="form-group__document-empty">
            {{ trans('documents.no_document_selected') }}
        </div>

        <div class="form-group__buttons">
            {!! button('', trans('general.clear'), 'button', 'button--clear') !!}{!!
            button('icon-image', trans('documents.library'), 'button', 'button--emphasis button--library') !!}
        </div>

        {!! Form::hidden($name, $options['value'], $options['attr']) !!}
    </div>
    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}