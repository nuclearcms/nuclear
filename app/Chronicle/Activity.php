<?php

namespace Reactor\Chronicle;


use Kenarkose\Chronicle\Activity as ChronicleActivity;

class Activity extends ChronicleActivity {

    /**
     * User relation for the activity
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(
            $this->getUserModelName()
        )->withTrashed();
    }

    /**
     * Returns the activity subject name
     *
     * @return string
     */
    public function getSubjectName()
    {
        return str_plural(strtolower(class_basename($this->subject_type)));
    }

}