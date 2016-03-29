<?php

namespace Reactor\Http\Controllers\Traits;


trait UsesProfileHelpers {

    /**
     * Returns the currently logged in user
     *
     * @return User
     */
    protected function getProfile()
    {
        return auth()->user();
    }
    
}