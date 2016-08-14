{!! activity_open($activity, false) !!}

{!! trans('activities.created_node_translation', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.contents.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}