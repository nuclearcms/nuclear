<?php

Route::get('locale/{locale}', function ($locale)
{
    if (in_array($locale, config('translatable.locales')))
    {
        session()->set('_locale', $locale);
    }

    return redirect()->back();
});