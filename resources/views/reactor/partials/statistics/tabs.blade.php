@section('children_tabs')
    <ul class="tabs" id="chartFlaps">
        <li class="tabs__flap">
            <span class="tabs__child-link tabs__child-link--active" data-mode="daily">{{ uppercase(trans('general.daily')) }}</span>
        </li>
        <li class="tabs__flap">
            <span class="tabs__child-link" data-mode="weekly">{{ uppercase(trans('general.weekly')) }}</span>
        </li>
        <li class="tabs__flap">
            <span class="tabs__child-link" data-mode="monthly">{{ uppercase(trans('general.monthly')) }}</span>
        </li>
    </ul>
@endsection