{!! field_wrapper_open($options, $name, $errors, 'form-group-tag') !!}

<div class="form-group-column form-group-column-field">
    {!! field_label($showLabel, $options, $name) !!}

    <div class="taglist-container">
        <ul class="taglist">

        </ul>
        <div class="tag-input">
            {!! Form::text('_tag', null, ['placeholder' => trans('hints.tags_placeholder')]) !!}
        </div>
        {!! Form::hidden($name, $options['value'], $options['attr']) !!}
    </div>

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}