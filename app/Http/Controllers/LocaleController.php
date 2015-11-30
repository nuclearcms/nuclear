<?php

namespace Reactor\Http\Controllers;


class LocaleController extends Controller {

    /**
     * Sets locale
     *
     * @param string $locale
     * @return Response
     */
    public function setLocale($locale)
    {
        if (in_array($locale, config('translatable.locales')))
        {
            session()->set('_locale', $locale);
        }

        return redirect()->back();
    }

}