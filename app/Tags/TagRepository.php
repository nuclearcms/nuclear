<?php

namespace Reactor\Tags;


class TagRepository {

    /**
     * Returns a tag by slug
     *
     * @param string $slug
     * @return Node
     */
    public function getTag($slug)
    {
        return Tag::whereTranslation('slug', $slug)
            ->firstOrFail();
    }

    /**
     * Returns a tag by slug and sets the locale
     *
     * @param $slug
     * @return Tag
     */
    public function getTagAndSetLocale($slug)
    {
        $tag = $this->getTag($slug);

        $locale = $tag->getLocaleForName($slug);

        set_app_locale($locale);

        return $tag;
    }

}