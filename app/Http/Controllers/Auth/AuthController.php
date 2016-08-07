<?php

namespace Reactor\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Reactor\User;
use Validator;
use Reactor\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{

    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);

        $this->redirectTo = route('reactor.dashboard');
    }

}
