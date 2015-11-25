@if($options['wrapper'] !== false)
    <div class="form-group form-group-content
        {{ $errors->has($name) ? 'error' : '' }}
        {{ (isset($options['inline']) and $options['inline']) ? 'inline' : '' }}"
        {!! $options['wrapperAttrs'] !!} >
@endif

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

    @include('fields.errors')

</div><div class="form-group-column form-group-column-help">
    @if( ! empty($options['help_block']['text']))
        {{ trans($options['help_block']['text']) }}
    @else
        @if(trans()->has('hints.' . $name))
            {{ trans('hints.' . $name) }}
        @endif
    @endif
</div>

@if($options['wrapper'] !== false)
    </div>
@endif