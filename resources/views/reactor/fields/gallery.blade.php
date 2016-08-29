{!! field_wrapper_open($options, $name, $errors) !!}

<div class="form-group-column form-group-column--{{ array_get($options, 'fullWidth', false) ? 'full' : 'field' }} ">
    {!! field_label($showLabel, $options, $name, $errors) !!}

    GALLERY FIELD

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}