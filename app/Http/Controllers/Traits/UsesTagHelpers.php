<?php

namespace Reactor\Http\Controllers\Traits;


use Reactor\Tags\Tag;

trait UsesTagHelpers {

    /**
     * Determines the current editing locale
     *
     * @param int $translation
     * @param Tag $tag
     * @return string
     */
    protected function determineLocaleAndTranslation($translation, Tag $tag)
    {
        $translation = $tag->translations->find($translation);

        if (is_null($translation))
        {
            abort(404);
        }

        return [$translation->locale, $translation];
    }

}