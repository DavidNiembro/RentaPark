<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
//Trait qui permet de faire la validation et le login de l'utilisateur à la place des fonctions native de Laravel.
use Bestmomo\LaravelEmailConfirmation\Traits\AuthenticatesUsers;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //Renvoi vers le dashboard
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Permet d'identifier un utilisateur avec son nom d'utilisateur au lieu de l'email
     *
     * @return useUsername
     */
    public function username()
    {
        return 'useUsername';
    }

}
