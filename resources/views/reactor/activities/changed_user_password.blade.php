{!! activity_open($activity) !!}

{!! trans('activities.changed_user_password', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.users.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}