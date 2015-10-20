<?php

namespace Reactor\Documents\Templates;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Thumbnail implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(180, 180);
    }
}