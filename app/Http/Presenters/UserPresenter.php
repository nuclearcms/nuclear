<?php

namespace Reactor\Http\Presenters;


use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter {

    public function avatar()
    {
            return str_limit($this->first_name, 1, '') .
                str_limit($this->last_name, 1, '') .
                '<img src="http://www.gravatar.com/avatar/' . md5($this->email) . '?d=blank">';
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function joinedAt()
    {
        return $this->created_at->formatLocalized('%b %e, %Y');
    }

}