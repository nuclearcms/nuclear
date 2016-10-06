<?php


namespace Reactor\Support\Packing;

use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;

class Filesystem extends IlluminateFilesystem {

    /**
     * Get an array of all files in a directory.
     *
     * We are overriding the base files method since
     * it does not include hidden files
     *
     * @param string $directory
     * @return array
     */
    public function files($directory)
    {
        // ONLY THE LINE BELOW IS CHANGED
        $glob = glob($directory. '/{,.}*', GLOB_BRACE);

        if ($glob === false) {
            return [];
        }

        // To get the appropriate files, we'll simply glob the directory and filter
        // out any "files" that are not truly files so we do not end up with any
        // directories in our list, but only true files within the directory.
        return array_filter($glob, function ($file) {
            return filetype($file) == 'file';
        });
    }

}