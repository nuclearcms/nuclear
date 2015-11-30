<?php

namespace Reactor\Http\Controllers;


use Reactor\Http\Requests;
use Reactor\Utilities\Update\UpdateService;

class UpdateController extends ReactorController {

    /**
     * Show the update page
     *
     * @param UpdateService $updateService
     * @return Response
     */
    public function index(UpdateService $updateService)
    {
        $latest = $updateService->getLatestRelease();

        return view('advanced.update', compact('latest', 'updateService'));
    }

    /**
     * Show the update start page
     *
     * @param UpdateService $updateService
     * @return Response
     */
    public function start(UpdateService $updateService)
    {
        if ($updateService->isNuclearCurrent())
        {
            flash()->error(trans('advanced.no_need_to_update'));

            return redirect()->route('reactor.advanced.update');
        }

        $latest = $updateService->getLatestRelease();

        return view('advanced.update.start', compact('latest', 'updateService'));
    }

}
