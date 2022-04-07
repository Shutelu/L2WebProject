<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /*
    ===========================================================================
        Ce controlleur servira pour l'authentification des utilisateurs :
            = user_login_form()
            = user_login(request)
            = logout(requet)
    ===========================================================================
    */

    public function user_login_form(){ //renvoie la page du formulaire de login
        return view('auth.auth_log_form');
    }

    public function user_login(Request $request){ //function pour le traitement des informations réccuperées par le formulaire de login

        $request->validate([
            'login' => 'required|string|max:40|min:1',
            'mdp' => 'required|max:40|min:1',
        ]);

        //on sauvegarde le login et le mot de passe
        //laveral utilise le champ de base 'password' nous utilisons ici 'mdp'
        $credit = [
            'login'=>$request->input('login'),
            'password'=>$request->input('mdp')
        ];
        
        //empecher les utilisateurs de type null de se connecter
        $user = User::where('login','=',$request->login)->first();
        if($user->type == null){
            return redirect()->route('pageIndex')->with('etat','L\'administrateur ne vous a pas encore accepter, vous ne pouvez pas encore vous connectez !');
        }

        //si authentification reussi
        if(Auth::attempt($credit)){
            $request->session()->regenerate();//regenerer la session
            $request->session()->flash('etat','Login reussi !');

            //mettre redirection vers page admin ou user ou cook
            if($request->user()->isAdmin()){
                return redirect()->intended('/admin_index');
            }
            return redirect()->intended('/');//rediriger là ou il voulait aller
        }

        //si fail renvoie page precedente
        return back()->withErrors([
            'login'=>'Les informations saisis ne sont pas correctes ou bien votre compte a été supprimé !',
        ]);

    }

    public function logout(Request $request){ //deconnecter le compte courant
        Auth::logout();//deco
        $request->session()->invalidate();//lutte contre les attaques basées sur les sessions
        $request->session()->regenerateToken();
        $request->session()->flash('etat','Déconnexion réussie !');
        return redirect('/');
    }
}
