<?php

namespace Reactor\Utilities\Update;


use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use ZipArchive;

class ExtractorService {

    /**
     * Path for keeping older files
     * belonging to the previous update
     *
     * @var string
     */
    const UPDATE_TRASH_DIR = '/trash';

    /**
     * For testing purposes we may set this
     * to '/updatetest' so that we won't replace the
     * actual files
     *
     * @var string
     */
    const UPDATE_DESTINATION_DIR = '';

    /**
     * The folder name when archive is extracted.
     *
     * nuclear_2.*.*.zip
     *  |__ /nuclear
     *       |__ files
     *
     * @var string
     */
    const UPDATE_ZIP_DIR = "/nuclear";

    /**
     * List of updateable files
     *
     * @var array
     */
    protected $updateableFiles = [
        'app',
        'bootstrap',
        'database',
        'resources/assets/reactor',
        'resources/lang',
        'resources/views/reactor',
        'routes/reactor.php',
        'vendor',
        'artisan',
        'LICENSE',
        'readme.md',
        'server.php'
    ];

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

        if ( ! $zip->extractTo($extractDir . '/'))
        {
            abort(500, trans('advanced.zip_could_not_be_extracted'));
        };

        $zip->close();

        $extractDir .= static::UPDATE_ZIP_DIR;

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
        $root = base_path() . static::UPDATE_DESTINATION_DIR;
        $fs = new Filesystem();

        $this->validateDirectories($fs, $extractedPath, $root);

        $trashPath = $this->emptyTrash($fs, $root);

        $this->replaceFiles($fs, $root, $extractedPath, $trashPath);
    }

    /**
     * @param Filesystem $fs
     * @param string $extractedPath
     * @param string $root
     */
    protected function validateDirectories(Filesystem $fs, $extractedPath, $root)
    {
        if ( ! $fs->exists($extractedPath))
        {
            throw new RuntimeException(trans('advanced.extracted_files_not_found'));
        }

        if ( ! is_writable($root))
        {
            throw new RuntimeException(trans('advanced.root_not_writable'));
        }
    }

    /**
     * @param Filesystem $fs
     * @param string $root
     * @return string
     */
    protected function emptyTrash(Filesystem $fs, $root)
    {
        $trashDir = $root . static::UPDATE_TRASH_DIR;

        if ($fs->exists($trashDir))
        {
            $fs->deleteDirectory($trashDir);
        }

        $fs->makeDirectory($trashDir, 0777, true);

        return $trashDir;
    }

    /**
     * @param Filesystem $fs
     * @param $root
     * @param $extractedPath
     * @param $trashPath
     */
    protected function replaceFiles(Filesystem $fs, $root, $extractedPath, $trashPath)
    {
        $files = $this->updateableFiles;

        foreach ($files as $file)
        {
            $this->replaceFile(
                $fs,
                $root . '/' . $file,
                $extractedPath . '/' . $file,
                $trashPath . '/' . $file
            );
        }
    }

    /**
     * @param Filesystem $fs
     * @param string $destination
     * @param string $temporary
     * @param string $trash
     */
    protected function replaceFile(Filesystem $fs, $destination, $temporary, $trash)
    {
        // Move to trash first if exists
        if ($fs->exists($destination))
        {
            $this->moveFileOrDirectory($fs, $destination, $trash);
        }

        // Move the file only if exists in the update
        if ($fs->exists($temporary))
        {
            $this->moveFileOrDirectory($fs, $temporary, $destination);
        }
    }

    /**
     * @param Filesystem $fs
     * @param string $source
     * @param string $destination
     */
    protected function moveFileOrDirectory(Filesystem $fs, $source, $destination)
    {
        if (is_dir($source))
        {
            $fs->copyDirectory($source, $destination);
            $fs->deleteDirectory($source);
        } else
        {
            // Create directory if it doesn't exist
            $parentDirectory = dirname($destination);

            if ( ! $fs->exists($parentDirectory))
            {
                $fs->makeDirectory($parentDirectory, 0777, true);
            }

            $fs->move($source, $destination);
        }
    }

}