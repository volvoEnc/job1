<?php

namespace App\Http\Controllers\Auth;

use App\Application;
use App\AuthToken;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'user') return redirect('/');
        else return redirect('/manager');

    }

    public function mailLogin ($auth_token, Application $application)
    {
        $auth_token = AuthToken::query()->where('token', $auth_token)->first();
        if (Auth::check()) Auth::logout();
        Auth::login($auth_token->user);
        return redirect(route('m-show', [
            'application' => $application->id
        ]));
    }

    /**
     * Create a new controller instance.
     *
     * @param $auth_token
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
