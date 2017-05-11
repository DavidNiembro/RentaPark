<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'useUsername' => 'required|string|max:255|unique:t_user',
            'useMail' => 'required|string|email|max:255|unique:t_user',
            'password' => 'required|string|min:6|confirmed',
            'usePictureProfil' => 'required',
            'useName' => 'required',
            'useFirstName' => 'required',
            'useCity' => 'required',
            'useLand' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'useUsername' => $data['useUsername'],
            'useMail' => $data['useMail'],
            'password' => bcrypt($data['password']),
            'usePictureProfil' => $data['usePictureProfil'],
            'useName' => $data['useName'],
            'useFirstName' => $data['useFirstName'],
            'useCity' => $data['useCity'],
            'useLand' => $data['useLand'],
        ]);
    }
}
