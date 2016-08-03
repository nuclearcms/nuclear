<?php


namespace Reactor\Http\Middleware;


use Closure;

class DetermineInstallation {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ( ! is_installed())
        {
            return redirect()->route('install-welcome');
        }

        return $next($request);
    }

}


