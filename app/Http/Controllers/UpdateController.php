<?php


namespace Reactor\Http\Controllers;


use Reactor\Support\Update\UpdaterService;

class UpdateController extends ReactorController {

    /**
     * Shows the updates page
     *
     * @param UpdaterService $updater
     * @return view
     */
    public function index(UpdaterService $updater)
    {
        $latest = $updater->getLatestRelease();

        return $this->compileView('update.index', compact('updater', 'latest'));
    }

    /**
     * Show the update start page
     *
     * @param UpdaterService $updater
     * @return Response
     */
    public function start(UpdaterService $updater)
    {
        if ($updater->isNuclearCurrent())
        {
            flash()->error(trans('update.no_need_to_update'));

            return redirect()->route('reactor.update.index');
        }

        $latest = $updater->getLatestRelease();

        return $this->compileView('update.start', compact('updater', 'latest'));
    }

}