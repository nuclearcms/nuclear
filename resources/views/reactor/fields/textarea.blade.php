{!! field_wrapper_open($options, $name, $errors) !!}

<div class="form-group-column form-group-column-field">
    {!! field_label($showLabel, $options, $name) !!}

    {!! Form::textarea($name, $options['value'], $options['attr']) !!}

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}