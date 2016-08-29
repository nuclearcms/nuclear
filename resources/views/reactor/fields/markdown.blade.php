{!! field_wrapper_open($options, $name, $errors) !!}

<div class="form-group-column form-group-column--full">
    {!! field_label($showLabel, $options, $name, $errors) !!}

    MARKDOWN FIELD<br>
    THIS WILL PROBABLY BE FULL WIDTH, MIND THE TOP

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}