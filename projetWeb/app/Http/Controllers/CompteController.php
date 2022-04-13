<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Cour;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CompteController extends Controller
{
    /*
    ===========================================================================
        Ce controlleur servira :
            - Pour la gestion du compte de User (auth), Admin, Gestionnaire:
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
                    = gestion_user_recherche(request)
                    = gestion_user_refus(id)
                    = gestion_user_accepter_form(id)
                    = gestions_user_accepter(request,id)
                    = gestions_user_create_form()
                    = gestion_user_create(request)
                    = gestion_cours_liste()
                    = gestion_cours_create(request)
                Pour Gestionnaire :
                    = gestionnaire_page_gestion()
                    = gestionnaire_gestion_etudiants()
                    = gestionnaire_create_etudiant_form()
                    = gestionnaire_create_etudiant(request)
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
            'filtreType' => 'required|in:defaut,enseignant,gestionnaire,admin'//"defaut" non utilisé mais doit etre present
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
        else if($request->filtreType == 'admin'){
            $users_liste = User::where('type','=','admin')->paginate(5);
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

    public function gestion_user_refus($id){//refus de la demander (suppression)
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('admin.gestion.user_liste')->with('etat','La demande de l\'utilisateur a été refuser, son compte a été supprimé !');
    }

    public function gestion_user_accepter_form($id){//formulaire d'acceptation
        $user = User::findOrFail($id);
        return view('admin.gestion.utilisateurs.gestion_accepter_form',['user'=>$user]);
    }

    public function gestions_user_accepter(Request $request, $id){//fonction d'acceptation
        $request->validate([
            'userAcceptation' => 'required|in:defaut,enseignant,gestionnaire',
        ]);
        $user = User::findOrFail($id);

        // //pour les personnes qui veulent tester ce que ca fait de laisser le choix par defaut
        // if($request->userAcceptation == 'defaut'){
        //     return view('admin.gestion.utilisateurs.gestion_accepter_form',['user'=>$user])->with('etat','Vous n\avez pas encore choisi le type de l\'utilisateur');
        // }

        $user->type = $request->userAcceptation;
        $user->save();
        
        return redirect()->route('admin.gestion.user_liste')->with('etat','L\'utilisateur a bien été accepté !');
    }

    public function gestions_user_create_form(){//affiche la page de creation d'un user
        return view('admin.gestion.utilisateurs.gestion_user_create_form');
    }

    public function gestion_user_create(Request $request){//fonction de creation de user par l'admin
        $request->validate([
            'nom' => 'required|string|min:1|max:40',
            'prenom' => 'required|string|min:1|max:40',
            'login' => 'required|string|min:1|max:30|unique:users',
            'mdp' => 'required|confirmed|min:1|max:60',
            'typeSelect' => 'required|in:enseignant,gestionnaire,admin',
        ]);

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom =$request->prenom;
        $user->login = $request->login;
        $user->mdp = Hash::make($request->mdp);
        $user->type = $request->typeSelect;
        $user->save();

        return redirect()->route('admin.gestion.user_liste')->with('etat','L\'utilisateur a été crée avec succès !');
    }

    public function gestion_cours_liste(){//affiche la liste des cours
        $cours_liste = Cour::paginate(5);
        return view('admin.gestion.cours.gestion_cours_liste',['cours_liste'=>$cours_liste]);
    }

    public function gestion_cours_create(Request $request){//cree un cours
        $request->validate([
            'intitule' => 'required|min:1|max:50'
        ]);

        $cour = new Cour();
        $cour->intitule = $request->intitule;
        $cour->save();

        return redirect()->route('admin.gestion.cours_liste')->with('etat','Le cours a bien été crée !');
    }

    /*
    ===============================
        Codes pour Gestionnaire :
    ===============================
    */

    public function gestionnaire_page_gestion(){//affiche page de gestion pour les gestionnaires ainsi que pour les admins
        return view('comptes.gestionnaire.gestionnaire_gestion');
    }

    public function gestionnaire_gestion_etudiants(){//page sur la gestion des etudiants
        $etudiants_liste = Etudiant::paginate(5);
        return view('comptes.gestionnaire.gestionnaire_gestion_etudiant',['etudiants_liste'=>$etudiants_liste]);
    }

    public function gestionnaire_create_etudiant_form(){//creation d'un etudiant
        return view('comptes.gestionnaire.gestionnaire_create_etudiant_form');
    }

    public function gestionnaire_create_etudiant(Request $request){
        $request->validate([
            'nom' => 'required|string|min:1|max:40',
            'prenom' => 'required|string|min:1|max:40',
            'noet' => 'numeric|digits:8|nullable|unique:etudiants'//non requis on utilisera le random
        ]);

        $etudiant = new Etudiant();
        $etudiant->nom = $request->nom;
        $etudiant->prenom = $request->prenom;
        if($request->noet){
            $etudiant->noet = $request->noet; 
        }
        else{
            $etudiant->noet = (string) rand(10000000,99999999);//numero etudiant random
        }
        //dd($etudiant->noet);
        $etudiant->save();

        return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','L\'étudiant(e) a été enregistré(e) !');
    }





}
