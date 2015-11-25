@if($options['wrapper'] !== false)
    <div class="form-group form-group-content form-group-tag {{ $errors->has($name) ? 'error' : '' }}" {!! $options['wrapperAttrs'] !!} >
@endif

<div class="form-group-column form-group-column-field">
    @if($showLabel && $options['label'] !== false)
        {!! Form::label($name,
            trans()->has('validation.attributes.' . $name) ? trans('validation.attributes.' . $name) : trans($options['label']),
            $options['label_attr']) !!}
    @endif

    <div class="taglist-container">
        <ul class="taglist">
            <li class="tag-input">
                {!! Form::text('_tag', null, ['placeholder' => trans('hints.tags_placeholder')]) !!}
            </li>
        </ul>
        {!! Form::hidden($name, $options['value'], $options['attr']) !!}
    </div>

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