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

    /**
     * Downloads the latest update
     *
     * @param UpdateService $updateService
     * @return Response
     */
    public function download(UpdateService $updateService)
    {
        if ($updateService->isNuclearCurrent())
        {
            abort(500, trans('advanced.no_need_to_update'));
        }

        $fileName = $updateService->downloadLatest();

        session()->set('_temporary_update_path', $fileName);

        return response()->json([
            'message' => trans('advanced.extracting_update'),
            'next' => route('reactor.advanced.update.extract'),
            'progress' => 40
        ]);
    }

    /**
     * Extracts the update
     *
     * @param UpdateService $updateService
     * @return Response
     */
    public function extract(UpdateService $updateService)
    {
        $updateService->extractUpdate(
            session('_temporary_update_path')
        );

        return response()->json([
            'message' => trans('advanced.finalizing_update'),
            'next' => route('reactor.advanced.update.finalize'),
            'progress' => 70
        ]);
    }

    /**
     * Extracts the update
     *
     * @param UpdateService $updateService
     * @return Response
     */
    public function finalize(UpdateService $updateService)
    {
        $updateService->finalizeUpdate();

        return response()->json([
            'message' => trans('advanced.update_complete'),
            'next' => null,
            'progress' => 100
        ]);
    }

}
