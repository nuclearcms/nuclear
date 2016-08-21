{!! field_wrapper_open($options, $name, $errors) !!}

<div class="form-group-column form-group-column--field">
    @if($showLabel && $options['label'] !== false)
        <div class="form-group__label{{ $errors->has($name) ? ' form-group__label--error ' : '' }}">
            {{ trans()->has('validation.attributes.' . $name) ? trans('validation.attributes.' . $name) : trans($options['label']) }}
        </div>
    @endif
    <label class="form-group__checkbox">
        {!! Form::hidden($name, 0, []) !!}
        {!! Form::checkbox($name, 1, $options['checked'], $options['attr']) !!}
        <span>
            <i class="form-group__checkbox-icon icon-cancel button__icon button__icon--right"> <span>{{ uppercase(trans('general.no')) }}</span></i><i class="form-group__checkbox-icon icon-confirm button__icon button__icon--right"> <span>{{ uppercase(trans('general.yes')) }}</span></i>
        </span>
    </label>

    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}