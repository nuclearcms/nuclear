<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Nuclear\Hierarchy\ContentsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param ContentsRepository $contentsRepository
     * @return void
     */
    public function boot(ContentsRepository $contentsRepository)
    {
        $this->registerViewBindings($contentsRepository);
    }

    /**
     * Registers default view bindings
     *
     * @param ContentsRepository $contentsRepository
     */
    protected function registerViewBindings(ContentsRepository $contentsRepository)
    {
        if (!is_installed()) return;
        
        if (!is_request_reactor())
        {
            $home = $contentsRepository->getHome(false, false);

            view()->share('home', $home);
        }
    }

}
