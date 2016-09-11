{!! activity_open($activity, false) !!}

{!! trans('activities.deleted_mailingnodes', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name
]) !!}

{!! activity_close() !!}