<?php

return [

    /**
     * The locales you wish to support.
     */
    'supported-locales' => explode(',', env('APP_LOCALES', 'en')),

    /**
     * If you have a main locale and don't want
     * to prefix it in the URL, specify it here.
     *
     * 'omit_url_prefix_for_locale' => 'en',
     */
    'omit_url_prefix_for_locale' => env('APP_LOCALE', 'en'),

    /**
     * If you want to automatically set the locale
     * for localized routes set this to true.
     */
    'use_locale_middleware' => true,

    /**
     * If true, this package will use 'codezero/laravel-localizer'
     * to detect and set the preferred supported locale.
     *
     * For non-localized routes, it will look for a locale in the URL,
     * in the session, in a cookie, in the browser or in the app config.
     * This can be very useful if you have a generic home page.
     *
     * If a locale is detected, it will be stored in the session,
     * in a cookie and as the app locale.
     *
     * If you disable this option, only localized routes will have a locale
     * and only the app locale will be set (so not in the session or cookie).
     *
     * You can publish its config file and tweak it for your needs.
     * This package will only override its 'supported-locales' option
     * with the 'supported-locales' option in this file.
     *
     * For more info, visit:
     * https://github.com/codezero-be/laravel-localizer
     *
     * This option only has effect if you use the SetLocale middleware.
     */
    'use_localizer' => true,

    /*
    |--------------------------------------------------------------------------
    | Full locale names.
    |--------------------------------------------------------------------------
    |
    | The locale names to be used by setting locale functions and html lang attribute.
    |
    */
    'full_locales' => [
        'en' => 'en.UTF-8',
        'tr' => 'tr_TR.UTF-8',
        'fr' => 'fr_FR.UTF-8',
        'de' => 'de_DE.UTF-8',
        'ru' => 'ru_RU.UTF-8',
        'es' => 'es_ES.UTF-8',
        'zh' => 'zh_CN.UTF-8',
        'ja' => 'ja_JP.UTF-8',
    ],

];
