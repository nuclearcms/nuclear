{!! field_wrapper_open($options, $name, $errors) !!}

<div class="form-group-column form-group-column-field">
    @if($showLabel && $options['label'] !== false)
        <div class="control-label">
            {{ trans()->has('validation.attributes.' . $name) ? trans('validation.attributes.' . $name) : trans($options['label']) }}
        </div>
    @endif
    <label class="button form-checkbox">
        {!! Form::hidden($name, 0, []) !!}
        {!! Form::checkbox($name, $options['value'], $options['checked'], $options['attr']) !!}
        <span>
            <i class="icon-cancel">{{ trans('general.no') }}</i><i class="icon-check">{{ trans('general.yes') }}</i>
        </span>
    </label>

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}