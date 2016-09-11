<?php


namespace Extension\Site\Providers;


use Illuminate\Support\ServiceProvider;

class SiteExtensionServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(dirname(__DIR__) . '/lang', 'site');
    }

}