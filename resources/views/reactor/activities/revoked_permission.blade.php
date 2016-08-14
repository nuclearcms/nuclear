{!! activity_open($activity) !!}

{!! trans('activities.revoked_permission', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.' . $activity->getSubjectName() . '.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}