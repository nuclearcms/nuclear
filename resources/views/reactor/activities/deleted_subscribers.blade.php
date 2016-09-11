{!! activity_open($activity) !!}

{!! trans('activities.deleted_subscribers', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name
]) !!}

{!! activity_close() !!}