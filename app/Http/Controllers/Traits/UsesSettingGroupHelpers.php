<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;

trait UsesSettingGroupHelpers {

    /**
     * @param Request $request
     * @return array|string
     */
    protected function setGroup(Request $request)
    {
        settings()->setGroup(
            $key = $request->input('key'),
            $request->input('name')
        );

        return $key;
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function findSettingGroupOrFail($key)
    {
        if ( ! settings()->hasGroup($key))
        {
            abort(404);
        }

        return settings()->getGroup($key);
    }

    /**
     * @param Request $request
     * @param $key
     */
    protected function updateGroup(Request $request, $key)
    {
        settings()->setGroup($key, $request->input('name'));
    }

}