{!! field_wrapper_open($options, $name, $errors) !!}

<div class="form-group-column form-group-column-field">
    {!! field_label($showLabel, $options, $name) !!}

    <?php $emptyVal = $options['empty_value'] ? ['' => $options['empty_value']] : null; ?>
    <div class="form-select-container">
        {!! Form::select($name, (array)$emptyVal + $options['choices'], $options['selected'], $options['attr']) !!}
        <i class="icon-down-dir"></i>
    </div>

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}