<?php

namespace Reactor\Utilities\Update;


use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use ZipArchive;

class ExtractorService {

    /**
     * Extracts the update in the given path
     *
     * @param string $updatePath
     * @return string
     * @throws RuntimeException
     */
    public function extract($updatePath)
    {
        $fs = new Filesystem();

        if ( ! $fs->exists($updatePath) || ! is_readable($updatePath))
        {
            throw new RuntimeException(trans('advanced.no_update_found'));
        }

        $zip = new ZipArchive();

        if ( ! $zip->open($updatePath))
        {
            throw new RuntimeException(trans('advanced.could_not_open_zip'));
        }

        $extractDir = $this->createExtractionDirectory($fs);
        $zip->extractTo($extractDir . '/');
        $zip->close();

        return $extractDir;
    }

    /**
     * Creates the temporary extraction directory
     *
     * @param Filesystem $fs
     * @return string
     * @throws RuntimeException
     */
    protected function createExtractionDirectory(Filesystem $fs)
    {
        $tempDirectory = tempnam(sys_get_temp_dir(), 'nuclear_update');

        if ($fs->exists($tempDirectory))
        {
            unlink($tempDirectory);
        }

        $fs->makeDirectory($tempDirectory);

        if (is_dir($tempDirectory))
        {
            return $tempDirectory;
        } else
        {
            throw new RuntimeException(trans('advanced.could_not_create_temporary_directory'));
        }
    }

    /**
     * Moves the update from the extracted path
     *
     * @param string $extractedPath
     */
    public function move($extractedPath)
    {

    }

}