<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

use App\Models\User;

class RegisterUserController extends Controller
{
    /*
    ===========================================================================
        Ce controlleur servira pour l'authentification des utilisateurs :
            = user_register_form()
            = user_register(request)
    ===========================================================================
    */

    public function user_register_form(){ //renvoie sur le formulaire d'enregistrement
        return view('auth.auth_reg_form');
    }

    public function user_register(Request $request){ //function pour le traitement du formulaire d'enregistrement
        $valid = $request->validate([
            'nom' => 'required|string|min:1|max:40',
            'prenom' => 'required|string|min:1|max:40',
            'login' => 'required|string|min:1|max:30|unique:users',
            'mdp' => 'required|confirmed|min:1|max:60'
        ]);

        $user = new User();
        $user->nom = $valid['nom'];
        $user->prenom = $valid['prenom'];
        $user->login = $valid['login'];
        $user->mdp = Hash::make($valid['mdp']); //ne pas stocker le mot de passe en clair et verifie
        $user->save();

        $request->session()->flash('etat','Votre demande a été enregistrée, veuillez attendre qu\'un administrateur valide votre compte !');
        //Auth::login($user); //connecter directement l'utilisateur

        return redirect()->route('pageIndex');

    }
}
