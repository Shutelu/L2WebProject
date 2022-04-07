<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CompteController extends Controller
{
    /*
    ===========================================================================
        Ce controlleur servira :
            - Pour la gestion du compte de User (auth), Admin :
                Pour User (utilisateurs connectés):
                    = user_mon_compte()
                    = user_edit_informations_forms()
                    = user_edit_informations(request)
                    = user_change_mdp_form()
                    = user_change_mdp(request)
                Pour Admin :
                    = admin_index()
                    = admin_page_gestion()
                    = admin_user_liste()
                    = gestion_user_liste_filtrage(request)
    ===========================================================================
    */

    /*
    ========================
        Codes pour User (auth) :
    ========================
    */

    public function user_mon_compte(){//affichage de la page de gestion du compte  
        $user = Auth::user();
        return view('comptes.user_mon_compte',['user'=>$user]);
    }

    public function user_edit_informations_form(){//formulaire d'édition des informations du compte
        $user = Auth::user();
        return view('comptes.user_edit_informations_form',['user'=>$user]);
    }

    public function user_edit_informations(Request $request){//fonction d'édition
        $request->validate([
            'nom' => 'required|string|max:40|min:1',
            'prenom' => 'required|string|max:40|min:1',
        ]);

        $user = Auth::user();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->save();

        return redirect()->route('user.page_mon_compte')->with('etat','Modification des informations de compte réussi !');        
    }

    public function user_change_mdp_form(){//formulaire de changement de mot de passe
        return view('comptes.user_change_mdp_form');
    }

    public function user_change_mdp(Request $request){//fonction de changement de mdp
        $request->validate([
            'ancien' => 'required|string|max:40|min:1',
            'mdp' => 'required|max:40|min:1|confirmed',
        ]);

        //si l'ancien mot de passe correspond
        if(Hash::check($request->ancien,Auth::user()->getAuthPassword())){
            $user = Auth::user();
            $user->mdp = Hash::make($request->mdp);
            $user->save();

            return redirect()->route('user.page_mon_compte')->with('etat','Changement de mot de passe réussi !');
        }

        return redirect()->route('user.change_mdp_form')->with('etat','Il semble que l\'ancien mot de passe n\'est pas correcte');
    }

    /*
    ========================
        Codes pour Admin :
    ========================
    */
    
    public function admin_index(){//affichage de la page index de l'administrateur
        return view('admin.admin_index');
    }

    public function admin_page_gestion(){//affiche la page de gestion pour l'admin
        return view('admin.gestion.admin_gestion'); 
    }

    public function admin_user_liste(){//affichage de la liste de tout les utlisateurs (intégrale)
        $users_liste = User::paginate(5);
        $choix = 'defaut';
        return view('admin.gestion.utilisateurs.gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
    }

    public function gestion_user_liste_filtrage(Request $request){//affichage de la liste des utilisateurs filtrer
        $request->validate([
            'filtreType' => 'required|in:defaut,enseignant,gestionnaire'//"defaut" non utilisé mais doit etre present
        ]);

        $choix = $request->filtreType;

        if($request->filtreType == 'enseignant'){
            $users_liste = User::where('type','=','enseignant')->paginate(5);
            return view('admin.gestion.utilisateurs.gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
        else if($request->filtreType == 'gestionnaire'){
            $users_liste = User::where('type','=','gestionnaire')->paginate(5);
            return view('admin.gestion.utilisateurs.gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
        else{
            $users_liste = User::paginate(5);
            return view('admin.gestion.utilisateurs.gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
    }

    public function gestion_user_recherche(Request $request){//recherche utilisateurs (attention code très long car 8 possibilités utilisé les fleches (vscode) pour reduire)
        $request->validate([
            'nom' => 'max:40',
            'prenom' =>'max:40',
            'login' => 'max:30',
        ]);

        // 8 possibilités (2^3)
        if(strlen($request->nom) > 0 && strlen($request->prenom) > 0 && strlen($request->login) > 0){//tout les info sont entrees

            $users_liste = User::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->where('login','=',$request->login)->paginate(5);
            $users_liste_verif = User::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->where('login','=',$request->login)->get();
            
            if($users_liste_verif){//si existe
                $choix = 'default';
                return view('/admin/gestion/utilisateurs/gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix])->with('etat','La recherche a été accepté');
            }
            else{
                return redirect()->route('admin.gestion.user_liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) > 0 && strlen($request->prenom) == 0 && strlen($request->login) == 0){//seulement le nom est entre

            $users_liste = User::where('nom','=',$request->nom)->paginate(5);
            $users_liste_verif = User::where('nom','=',$request->nom)->get();

            if($users_liste_verif){
                $choix = 'default';
                return view('/admin/gestion/utilisateurs/gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix])->with('etat','La recherche a été accepté');
            }
            else{
                return redirect()->route('admin.gestion.user_liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) == 0 && strlen($request->prenom) > 0 && strlen($request->login) == 0){//seulement le prenom est entre

            $users_liste = User::where('prenom','=',$request->prenom)->paginate(5);
            $users_liste_verif = User::where('prenom','=',$request->prenom)->get();

            if($users_liste_verif){//si existe
                $choix = 'default';
                return view('/admin/gestion/utilisateurs/gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix])->with('etat','La recherche a été accepté');
            }
            else{
                return redirect()->route('admin.gestion.user_liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) == 0 && strlen($request->prenom) == 0 && strlen($request->login) > 0){//seulement le login est entre
            $users_liste = User::where('login','=',$request->login)->paginate(5);
            $users_liste_verif = User::where('login','=',$request->login)->get();

            if($users_liste_verif){//si existe
                $choix = 'default';
                return view('/admin/gestion/utilisateurs/gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix])->with('etat','La recherche a été accepté');
            }
            else{
                return redirect()->route('admin.gestion.user_liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) > 0 && strlen($request->prenom) > 0 && strlen($request->login) == 0){//seulement nom et prenom
            $users_liste = User::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->paginate(5);
            $users_liste_verif = User::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->get();

            if($users_liste_verif){//si existe
                $choix = 'default';
                return view('/admin/gestion/utilisateurs/gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix])->with('etat','La recherche a été accepté');
            }
            else{
                return redirect()->route('admin.gestion.user_liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) > 0 && strlen($request->prenom) == 0 && strlen($request->login) > 0){//seulement nom et login
            $users_liste = User::where('nom','=',$request->nom)->where('login','=',$request->login)->paginate(5);
            $users_liste_verif = User::where('nom','=',$request->nom)->where('login','=',$request->login)->get();

            if($users_liste_verif){//si existe
                $choix = 'default';
                return view('/admin/gestion/utilisateurs/gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix])->with('etat','La recherche a été accepté');
            }
            else{
                return redirect()->route('admin.gestion.user_liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) == 0 && strlen($request->prenom) > 0 && strlen($request->login) > 0){//seulement prenom et login
            $users_liste = User::where('prenom','=',$request->prenom)->where('login','=',$request->login)->paginate(5);
            $users_liste_verif = User::where('prenom','=',$request->prenom)->where('login','=',$request->login)->get();

            if($users_liste_verif){//si existe
                $choix = 'default';
                return view('/admin/gestion/utilisateurs/gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix])->with('etat','La recherche a été accepté');
            }
            else{
                return redirect()->route('admin.gestion.user_liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else{//rien est saisi pour la recherche
            return redirect()->route('admin.gestion.user_liste')->with('etat','Aucun information n\'a été entrée !');
        }
    }
}
