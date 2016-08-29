{!! field_wrapper_open($options, $name, $errors, 'form-group--slug') !!}

<div class="form-group-column form-group-column--{{ array_get($options, 'fullWidth', false) ? 'full' : 'field' }} ">
    {!! field_label($showLabel, $options, $name, $errors) !!}

    {!! Form::text($name, $options['value'], $options['attr']) !!}

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}