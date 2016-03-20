<?php

namespace Reactor\Http\Middleware;


use Closure;

class DetermineLocale {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = session()->has('_locale') ?
            session('_locale') :
            $request->getPreferredLanguage();

        if (in_array($locale, config('translatable.locales')))
        {
            app()->setLocale($locale);
        }

        return $next($request);
    }

}