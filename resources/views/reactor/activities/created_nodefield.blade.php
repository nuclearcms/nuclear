{!! activity_open($activity) !!}

{!! trans('activities.created_nodefield', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.nodes.field.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}