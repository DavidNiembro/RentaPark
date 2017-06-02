<?php

/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Contient les fonctions pour la page Dashboard
 */

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche la page Dashboard
     *
     * @return la vue Dashboard avec la variable user
     */
    public function dashboard()
    {
        $user = User::find(Auth::id());
        return view('userProfile/dashboard', compact('user'));
    }
}
