<?php

namespace Reactor\Support;


use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Session\SessionManager;

class LocaleManager {

    /**
     * @var Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @var Illuminate\Session\SessionManager
     */
    protected $session;

    /**
     * Constructor
     *
     * @param Application $app
     * @param SessionManager $session
     * @param Repository $config
     */
    public function __construct(Application $app, SessionManager $session, Repository $config)
    {
        $this->config = $config;
        $this->app = $app;
        $this->session = $session;
    }

    /**
     * Sets the app locale
     *
     * @param string $locale
     * @return void
     */
    public function setAppLocale($locale = null)
    {
        $locale = $locale ?: $this->session->get('_locale', null);

        if ($locale)
        {
            $this->app->setLocale($locale);

            $this->session->put('_locale', $locale);

            $this->setTimeLocale($locale);
        }
    }

    /**
     * Sets the time locale
     *
     * @param string $locale
     * @return void
     */
    public function setTimeLocale($locale = null)
    {
        $locale = $locale ?: $this->session->get('_locale', $this->app->getLocale());

        setlocale(LC_TIME, $this->config->get('app.full_locales.' . $locale, null));

        Carbon::setLocale($locale);
    }

}