@if($options['wrapper'] !== false)
    <div class="form-group form-group-content form-group-password {{ $errors->has($name) ? 'error' : '' }}" {!! $options['wrapperAttrs'] !!} >
        @endif

        <div class="form-group-column form-group-column-field">
            @if($showLabel && $options['label'] !== false)
                {!! Form::label($name,
                    trans()->has('validation.attributes.' . $name) ? trans('validation.attributes.' . $name) : trans($options['label']),
                    $options['label_attr']) !!}
            @endif

            {!! Form::input($type, $name, $options['value'], $options['attr']) !!}

            @if(isset($options['meter']) and $options['meter'])
                <div class="strength-meter">
                    <div> </div>
                </div>
            @endif

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