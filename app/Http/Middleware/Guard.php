<?php

namespace Reactor\Http\Middleware;


use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Guard {

    use AuthorizesRequests;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $this->authorize($role);

        return $next($request);
    }
}
