{!! trans('activities.created_user', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.users.edit', $activity->subject_id)
]) !!}