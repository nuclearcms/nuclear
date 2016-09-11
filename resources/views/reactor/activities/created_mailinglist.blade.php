{!! activity_open($activity) !!}

{!! trans('activities.created_mailinglist', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.mailing_lists.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}