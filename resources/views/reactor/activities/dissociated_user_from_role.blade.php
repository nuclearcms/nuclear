{!! activity_open($activity) !!}

{!! trans('activities.dissociated_user_from_role', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.roles.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}