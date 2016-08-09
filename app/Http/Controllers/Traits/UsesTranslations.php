<?php

namespace Reactor\Http\Controllers\Traits;


trait UsesTranslations {

    /**
     * @param mixed $locale
     * @param bool $withFallback
     * @return string
     */
    protected function validateLocale($locale, $withFallback = false)
    {
        $locale = is_object($locale) ? $locale->input('locale') : $locale;

        if ( ! in_array($locale, config('translatable.locales')))
        {
            if ($withFallback)
            {
                return app()->getLocale();
            }

            abort(500);
        }

        return $locale;
    }

    /**
     * @param $model
     * @return array
     */
    protected function getAvailableLocales($model)
    {
        $locales = [];

        $modelTranslations = $model->translations
            ->lists('locale')->toArray();

        foreach (config('translatable.locales') as $locale)
        {
            if ( ! in_array($locale, $modelTranslations))
            {
                $locales[$locale] = trans('general.' . $locale);
            }
        }

        return $locales;
    }

}