{!! field_wrapper_open($options, $name, $errors) !!}

<div class="form-group-column form-group-column--full">
    {!! field_label($showLabel, $options, $name, $errors) !!}

    <div class="form-group__markdown">
        {!! Form::textarea($name, $options['value'], $options['attr']) !!}
    </div>

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}