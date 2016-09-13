{!! activity_open($activity, false, ($activity->subject && ($cover = $activity->subject->getCoverImage())) ? $cover->present()->thumbnail : '') !!}

{!! trans('activities.deleted_node_translation', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.nodes.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}