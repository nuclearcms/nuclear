<?php

namespace Reactor\Http;


use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Reactor\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Reactor\Http\Middleware\VerifyCsrfToken::class,
            \Reactor\Http\Middleware\RedirectIfNotInstalled::class,
            \Reactor\Http\Middleware\DetermineLocale::class
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'       => \Reactor\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can'        => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest'      => \Reactor\Http\Middleware\RedirectIfAuthenticated::class,
        'secure'     => \Reactor\Http\Middleware\ForceSecure::class,
        'set-theme'  => \igaster\laravelTheme\Middleware\setTheme::class,
        'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'track'      => \Kenarkose\Tracker\TrackerMiddleware::class
    ];
}
