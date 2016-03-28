<?php

namespace Reactor\Http\Builders;


use Reactor\Chronicle\Activity;

class ActivitiesHtmlBuilder {

    /**
     * Creates an activity opening tag
     *
     * @param Activity $activity
     * @param bool $minor
     * @return string
     */
    public function activityOpen(Activity $activity, $minor = true)
    {
        if ($minor)
        {
            $html = '<li class="activity activity-minor">';
        } else
        {
            $html = '<li class="activity">
                <div class="activity-actor"><span class="user-frame">' .
                $activity->user->present()->avatar .
                '</span></div>';
        }

        return $html .= '<div class="activity-subject">
            <span class="time">' . $activity->created_at->diffForHumans() . '</span>
                <p class="subject">';
    }

    /**
     * Creates an activity closing tag
     *
     * @return string
     */
    public function activityClose()
    {
        return '</p></div></li>';
    }
    
}