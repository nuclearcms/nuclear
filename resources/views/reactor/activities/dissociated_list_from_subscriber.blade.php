{!! activity_open($activity) !!}

{!! trans('activities.dissociated_list_from_subscriber', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.subscribers.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}