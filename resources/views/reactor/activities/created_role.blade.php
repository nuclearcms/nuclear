{!! trans('activities.created_role', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.roles.edit', $activity->subject_id)
]) !!}