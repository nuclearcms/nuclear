<?php

namespace Reactor\Html\Builders;


use Kenarkose\Chronicle\Activity;

class ActivitiesHtmlBuilder {

    /**
     * Creates an activity opening tag
     *
     * @param Activity $activity
     * @param bool $minor
     * @param string $thumbnail
     * @return string
     */
    public function activityOpen(Activity $activity, $minor = true, $thumbnail = '')
    {
        if ($minor)
        {
            $html = '<li class="activity activity--minor">';
        } else
        {
            $html = '<li class="activity">
                <div class="activity__actor"><span class="navigation-user__avatar">' .
                $activity->user->present()->avatar .
                '</span>' . (empty($thumbnail) ? '' : '<div class="activity__thumbnail">' . $thumbnail . '</div>') . '</div>';
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