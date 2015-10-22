<?php

namespace Reactor\Documents;


trait Embeddable {

    /**
     * Public url accessor
     *
     * @return string
     */
    public function getPublicURL()
    {
        return $this->path;
    }

    /**
     * Deletes the file from the filesystem
     * (this method is an override for the delete method on Deletable)
     *
     * @return bool
     */
    protected function deleteFile()
    {
        return true;
    }

}