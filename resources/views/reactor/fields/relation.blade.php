{!! field_wrapper_open($options, $name, $errors) !!}

<div class="form-group-column form-group-column--field">
    {!! field_label($showLabel, $options, $name, $errors) !!}

    <div class="form-group__relation"
         data-searchurl="{{ route($options['search_route']) }}"
         data-mode="{{ isset($options['mode']) ? $options['mode'] : 'single' }}">
        <ul class="related-items">

            @if($items = call_user_func($options['getter_method'], $options['value']))
            @foreach($items as $item)
            <li class="related-item" data-id="{{ $item->getKey() }}">
                {{ $item->getTitle() }}
                <i class="icon-cancel related-item__close"></i>
            </li>
            @endforeach
            @endif

        </ul>

        <div class="related-search">

            <input type="text" name="_relatedsearch" placeholder="{{ trans('general.search') }}" autocomplete="off">

            <ul class="related-search__results">

            </ul>
        </div>

        {!! Form::hidden($name, $options['value'], $options['attr']) !!}
    </div>
    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}