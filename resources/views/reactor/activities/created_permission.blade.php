{!! activity_open($activity) !!}

{!! trans('activities.created_permission', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.permissions.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}