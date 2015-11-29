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
        if (session()->has('_locale'))
        {
            $locale = session('_locale');

            if (in_array($locale, config('translatable.locales')))
            {
                \App::setLocale($locale);
            }
        }

        return $next($request);
    }

}