{!! trans('activities.created_media', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.documents.edit', $activity->subject_id)
]) !!}