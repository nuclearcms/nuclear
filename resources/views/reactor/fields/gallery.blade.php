{!! field_wrapper_open($options, $name, $errors, 'form-group-gallery') !!}

<div class="form-group-column form-group-column-field">
    {!! field_label($showLabel, $options, $name) !!}

    @if($gallery = get_reactor_gallery($options['value']))
    <div class="form-media-container">
        <ul class="form-media-gallery material-light">
            @foreach($gallery as $media)
                <li data-id="{{ $media->getKey() }}">
                    {!! $media->present()->thumbnail !!}
                    <i class="icon-cancel"></i>
                </li>
            @endforeach
    @else
    <div class="form-media-container empty">
        <ul class="form-media-gallery material-light">
    @endif
        </ul>
        <div class="form-empty-notification">
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