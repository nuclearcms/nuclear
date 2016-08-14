<?php

namespace Reactor\Html\Builders;


use Kenarkose\Chronicle\Activity;

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
            $html = '<li class="activity activity--minor">';
        } else
        {
            $html = '<li class="activity">
                <div class="activity__actor"><span class="navigation-user__avatar">' .
                $activity->user->present()->avatar .
                '</span></div>';
        }

        return $html .= '<div class="activity__subject">
            <span class="activity__time">' . $activity->created_at->diffForHumans() . '</span>
                <p class="activity__text">';
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