{!! activity_open($activity, false, ($activity->subject && ($cover = $activity->subject->getCoverImage())) ? $cover->present()->thumbnail : '') !!}

{!! trans('activities.updated_node_content', [
    'actorLink' => route('reactor.users.edit', $activity->user->getKey()),
    'actorName' => $activity->user->first_name,
    'subjectLink' => route('reactor.nodes.edit', $activity->subject_id)
]) !!}

{!! activity_close() !!}