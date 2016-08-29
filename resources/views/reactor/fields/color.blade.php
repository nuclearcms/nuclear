{!! field_wrapper_open($options, $name, $errors) !!}

<div class="form-group-column form-group-column--{{ array_get($options, 'fullWidth', false) ? 'full' : 'field' }} ">
    {!! field_label($showLabel, $options, $name, $errors) !!}

    <div class="form-group__color">
        {!! Form::text($name, $options['value'], array_set($options['attr'], 'class', 'minicolors')) !!}
    </div>

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}