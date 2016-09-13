{!! activity_open($activity, false, ($activity->subject && ($cover = $activity->subject->getCoverImage())) ? $cover->present()->thumbnail : '') !!}

{!! trans('activities.created_mailingnode', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.mailings.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}