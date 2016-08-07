<?php

namespace Reactor\Http\Controllers\Auth;

use Reactor\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware());

        $this->redirectTo = route('reactor.dashboard');
    }
}
