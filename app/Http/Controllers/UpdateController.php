<?php


namespace Reactor\Http\Controllers;


use Reactor\Support\Update\ExtractionService;
use Reactor\Support\Update\UpdateService;

class UpdateController extends ReactorController {

    /**
     * Shows the updates page
     *
     * @param UpdateService $updater
     * @return view
     */
    public function index(UpdateService $updater)
    {
        $latest = $updater->getLatestRelease();

        return $this->compileView('update.index', compact('updater', 'latest'));
    }

    /**
     * Show the update start page
     *
     * @param UpdateService $updater
     * @return Response
     */
    public function start(UpdateService $updater)
    {
        if ($updater->isNuclearCurrent())
        {
            flash()->error(trans('update.no_need_to_update'));

            return redirect()->route('reactor.update.index');
        }

        $latest = $updater->getLatestRelease();

        return $this->compileView('update.start', compact('updater', 'latest'), trans('update.auto_update'));
    }

    /**
     * Downloads the latest update
     *
     * @param UpdateService $updater
     * @return Response
     */
    public function download(UpdateService $updater)
    {
        if ($updater->isNuclearCurrent())
        {
            abort(500, trans('update.no_need_to_update'));
        }

        $fileName = $updater->downloadLatest();

        session()->set('_temporary_update_path', $fileName);

        return response()->json([
            'message'  => trans('update.extracting_update'),
            'next'     => route('reactor.update.extract'),
            'progress' => 30
        ]);
    }

    /**
     * Extracts the update
     *
     * @param UpdateService $updater
     * @param ExtractionService $extractor
     * @return Response
     */
    public function extract(UpdateService $updater, ExtractionService $extractor)
    {
        $path = session('_temporary_update_path');

        if (empty($path))
        {
            abort(500, trans('update.no_update_found'));
        }

        $extractedPath = $updater->extractUpdate(
            session('_temporary_update_path'), $extractor
        );

        session()->set('_extracted_update_path', $extractedPath);

        return response()->json([
            'message'  => trans('update.moving_files'),
            'next'     => route('reactor.update.move'),
            'progress' => 55
        ]);
    }

    /**
     * Moves the extracted update files
     *
     * @param UpdateService $updater
     * @param ExtractionService $extractor
     * @return Response
     */
    public function move(UpdateService $updater, ExtractionService $extractor)
    {
        $path = session('_extracted_update_path');

        if (empty($path))
        {
            abort(500, trans('update.extracted_files_not_found'));
        }

        $updater->moveUpdate($path, $extractor);

        return response()->json([
            'message'  => trans('update.finalizing_update'),
            'next'     => route('reactor.update.finalize'),
            'progress' => 80
        ]);
    }

    /**
     * Extracts the update
     *
     * @param UpdateService $updater
     * @return Response
     */
    public function finalize(UpdateService $updater)
    {
        $updater->finalizeUpdate();

        session()->forget('_temporary_update_path');
        session()->forget('_extracted_update_path');

        return response()->json([
            'message'  => trans('update.update_complete'),
            'next'     => null,
            'progress' => 100
        ]);
    }

}