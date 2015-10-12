{!! trans('activities.deleted_user', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name
]) !!}