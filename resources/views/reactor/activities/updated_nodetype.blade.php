{!! activity_open($activity) !!}

{!! trans('activities.updated_nodetype', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.nodetypes.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}