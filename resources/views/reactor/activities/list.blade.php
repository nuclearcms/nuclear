<ul class="activity-feed">
    @if($activities->count())
        @foreach($activities as $activity)
            <li class="activity">
                <div class="activity-actor">
                    <span class="user-frame">
                        {{ $activity->user->present()->avatar }}
                    </span>
                </div><div class="activity-subject">
                    <span class="time">{{ $activity->created_at->diffForHumans() }}</span>
                    <p class="subject">
                        @include('activities.' . $activity->name)
                    </p>
                </div>
            </li>
        @endforeach
    @else
        <li class="activity-empty">
            {{ trans('activities.no_user_activity') }}
        </li>
    @endif
</ul>