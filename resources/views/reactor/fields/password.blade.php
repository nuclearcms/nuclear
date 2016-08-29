{!! field_wrapper_open($options, $name, $errors, 'form-group--password') !!}

<div class="form-group-column form-group-column--{{ array_get($options, 'fullWidth', false) ? 'full' : 'field' }} ">
    {!! field_label($showLabel, $options, $name, $errors) !!}

    {!! Form::input($type, $name, $options['value'], $options['attr']) !!}

    @if(isset($options['meter']) and $options['meter'])
        <div class="form-group__password">
            <div class="password-strength"> </div>
        </div>
    @endif

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}