{!! field_wrapper_open($options, $name, $errors, 'form-group--gallery') !!}

<div class="form-group-column form-group-column--{{ array_get($options, 'fullWidth', false) ? 'full' : 'field' }} ">
    {!! field_label($showLabel, $options, $name, $errors) !!}

    <div class="form-group__gallery-container{{ ($gallery = get_nuclear_gallery(request()->old($name, null) ?: $options['value'])) ? '' : ' empty' }}">
        <div class="dropzone dropzone--library dropzone--gallery"
              data-action="{{ route('reactor.documents.store') }}"
              data-maxsize="{{ max_upload_size() }}">
            <i class="icon-upload dropzone__icon"></i>
        </div>

        <ul class="form-group__gallery">
            @if($gallery)
                @foreach($gallery as $slide)
                <li class="form-group__slide" data-id="{{ $slide->getKey() }}" data-type="image" title="{{ $slide->name }}" data-summary="{{ $slide->summarize(true) }}">
                    {!! $slide->present()->thumbnail !!}
                    <i class="icon-cancel"></i>
                </li>
                @endforeach
            @endif
        </ul>

        <div class="form-group__gallery-empty">
            {{ trans('documents.no_document_selected') }}
            <p>{{ trans('documents.drop_images_to_upload') }}</p>
        </div>

        <div class="form-group__buttons">
            {!! button('', trans('general.clear'), 'button', 'button--clear') !!}{!!
            button('icon-image', trans('documents.library'), 'button', 'button--emphasis button--library') !!}
        </div>

        {!! Form::hidden($name, request()->old($name, null) ?: $options['value'], $options['attr']) !!}
    </div>

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}