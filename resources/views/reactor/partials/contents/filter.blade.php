{!! header_action_open('general.filter', 'header__action--left') !!}
<div class="form-group__select header__select">
    <?php
    $currentFilter = in_array(request('f', $defaultFilter), $filterTypes) ? request('f', $defaultFilter) : $defaultFilter;
    ?>
    <select name="_filter" id="contentFilter">
        @foreach($filterTypes as $filter)
            <option value="{{ $filter }}"
                data-filterurl="{{ route('reactor.' . $key . '.' . ($filterSearch ? 'search' : 'index'), ['f' => $filter, 'q' => request('q')]) }}"
                {!! ($currentFilter === $filter) ? 'selected' : '' !!}
            >{{ trans($key . '.filter_' . $filter) }}</option>
        @endforeach
    </select>
    <i class="icon-arrow-down"></i>
</div>
{!! header_action_close() !!}