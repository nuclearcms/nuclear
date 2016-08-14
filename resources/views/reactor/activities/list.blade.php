<ul class="activity-feed">
    @if($activities->count())
        @foreach($activities as $activity)
            @include('activities.' . $activity->name)
        @endforeach
    @else
        <li class="activity activity--empty">
            {{ trans('activities.no_user_activity') }}
        </li>
    @endif
</ul>