<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Seance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CompteController extends Controller
{
    /*
    ===========================================================================
        Ce controlleur servira :
            - Pour la gestion du compte de User (auth), Enseignant, Admin, Gestionnaire:
                Pour User (utilisateurs connectés):
                    = user_mon_compte()
                    = user_edit_informations_forms()
                    = user_edit_informations(request)
                    = user_change_mdp_form()
                    = user_change_mdp(request)
                Pour Enseignant :
                    = enseignant_liste_cours_associer(id)
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
                    = gestionnaire_gestion_seances()
                    = gestionnaire_create_seance_form(id)
                    = gestionnaire_create_seance(request,id)
                    = gestionnaire_gestion_cours()
                    = gestionnaire_gestion_association_cours_etudiant(id)
                    = gestionnaire_gestion_asso_association_cours_etudiant(eid,cid)
                    = gestionnaire_gestion_desassociation_cours_etudiant(id)
                    = gestionnarie_gestion_desa_desassociation_cours_etudiant(eid,cid)
                    = gestionnaire_gestion_liste_cours_etudiants(id)
                    = gestionnaire_gestion_liste_enseignants()
                    = gestionnaire_gestion_association_cours_enseignant(id)
                    = gestionnaire_gestion_asso_association_cours_enseignant(eid,cid)
                    = gestionnaire_gestion_desassociation_cours_enseignant(id)
                    = gestionnaire_gestion_desa_desassociation_cours_enseignant(eid,cid)
                    = gestionnaire_gestion_liste_cours_enseignants(id)
    ===========================================================================
    */

    /*
    ==============================
        Codes pour User (auth) :
    ==============================
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
    ============================
        Codes pour Enseignant :
    ============================
    */

    public function enseignant_liste_cours_associer($id){//liste dse cours associer sans pagination 
        $enseignant = User::findOrFail($id);

        //gestion pour admin
        if($enseignant->type == 'admin'){
            $liste_cours = Cour::all();
            return view('comptes.enseignant.enseignant_liste_cours_associer',['liste_cours'=>$liste_cours,'enseignant_id'=>$id]);
        }

        $liste_cours = $enseignant->cours;

        return view('comptes.enseignant.enseignant_liste_cours_associer',['liste_cours'=>$liste_cours,'enseignant_id'=>$id]);
    }

    public function enseignant_liste_inscrit_cours($cid, $eid){
        // $enseingnant = User::findOrFail
        $cours = Cour::findOrFail($cid);
        $liste_etudiants = $cours->etudiants;

        return view('comptes.enseignant.enseignant_liste_inscrit_cours',['liste_etudiants'=>$liste_etudiants,'enseignant_id'=>$eid,'cours'=>$cours]);
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
            // $users_liste = User::where('type','=','enseignant')->paginate(5);
            $users_liste = User::where('type','=','enseignant')->get();
            return view('admin.gestion.utilisateurs.gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
        else if($request->filtreType == 'gestionnaire'){
            // $users_liste = User::where('type','=','gestionnaire')->paginate(5);
            $users_liste = User::where('type','=','gestionnaire')->get();
            return view('admin.gestion.utilisateurs.gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
        else if($request->filtreType == 'admin'){
            // $users_liste = User::where('type','=','admin')->paginate(5);
            $users_liste = User::where('type','=','admin')->get();
            return view('admin.gestion.utilisateurs.gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
        else{
            $users_liste = User::paginate(5);
            return view('admin.gestion.utilisateurs.gestion_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
    }

    //à réduire si assez de temps
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
        return view('comptes.gestionnaire..statistiques.gestionnaire_gestion_etudiant',['etudiants_liste'=>$etudiants_liste]);
    }

    public function gestionnaire_create_etudiant_form(){//creation d'un etudiant
        return view('comptes.gestionnaire.gestionnaire_create_etudiant_form');
    }

    public function gestionnaire_create_etudiant(Request $request){//fonction de creation de l'etudiant
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

    public function gestionnaire_gestion_seances(){//affichage des la liste de seances de cours
        $liste_seances = Seance::paginate(5);
        // $liste_test = Seance::all();
        // dd($liste_test[0]->cour->intitule);
        return view('comptes.gestionnaire.statistiques.gestionnaire_gestion_seance',['liste_seances'=>$liste_seances]);
    }

    public function gestionnaire_create_seance_form($id){
        $cours = Cour::findOrFail($id);
        return view('comptes.gestionnaire.gestionnaire_create_seances_form',['cours'=>$cours]);
    }

    public function gestionnaire_create_seance(Request $request, $id){//fonction de creation d'une seance de cours
        $request->validate([
            'ddebut' => 'required|date|after:yesterday',
            'dfin' => 'required|date|after:ddebut',
            // 'ddebutHeure' => 'required|numeric|max:23|min:0',
            // 'ddebutMin' => 'required|numeric|max:59|min:0',
            // 'dfinHeure' => 'required|numeric|max:23|min:0',
            // 'dfinMin' => 'required|numeric|max:59|min:0',
            
        ]);

        $cours = Cour::findOrFail($id);
        $seances = new Seance();
        $seances->date_debut = $request->ddebut;
        $seances->date_fin = $request->dfin;
        $cours->seances()->save($seances);
        $seances->cour()->associate($cours);//cette ligne ne sert a rien a enlever

        return redirect()->route('gestionnaire.gestion.gestion_cours')->with('etat','La séance a été crée !');
    }

    public function gestionnaire_gestion_cours(){//affichage de la liste des cours
        $liste_cours = Cour::paginate(5);
        return view('comptes.gestionnaire.statistiques.gestionnaire_gestion_cours',['liste_cours'=>$liste_cours]);
    }

    public function gestionnaire_gestion_association_cours_etudiant($id){//liste des cours pour association
        $liste_cours = Cour::paginate(5);
        return view('comptes.gestionnaire.associations.gestionnaire_associer_cours_etudiant',['liste_cours'=>$liste_cours,'etudiant_id'=>$id]);
    }

    public function gestionnaire_gestion_asso_association_cours_etudiant($eid,$cid){//association
        $cours = Cour::findOrFail($cid);
        $etudiant = Etudiant::findOrFail($eid);

        $etudiant->cours()->attach($cours);

        return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','L\'association a été effectué !');
    }

    public function gestionnaire_gestion_desassociation_cours_etudiant($id){//liste des cours pour desassociation
        $etudiant = Etudiant::findOrFail($id);

        $liste_cours = $etudiant->cours;

        return view('comptes.gestionnaire.associations.gestionnaire_desassocier_cours_etudiant',['liste_cours'=>$liste_cours,'etudiant_id'=>$id]);
    }

    public function gestionnarie_gestion_desa_desassociation_cours_etudiant($eid, $cid){//desassociation
        $etudiant = Etudiant::findOrFail($eid);
        $cours = Cour::findOrFail($cid);

        $etudiant->cours()->detach($cours);

        return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','Le cours a été désassocié à l\'étudiant(e) !');
    }

    public function gestionnaire_gestion_liste_cours_etudiants($id){//liste des etudiants associer au cours $id
        $cours = Cour::findOrFail($id);
        $liste_etudiants = $cours->etudiants;

        return view('comptes.gestionnaire.associations.gestionnaire_liste_cours_etudiant',['liste_etudiants'=>$liste_etudiants,'cours'=>$cours]);
    }

    public function gestionnaire_gestion_liste_enseignants(){//affichage liste des enseignants
        $liste_enseignants = User::where('type','=','enseignant')->paginate(5);
        return view('comptes.gestionnaire.statistiques.gestionnaire_gestion_liste_enseignants',['liste_enseignants'=>$liste_enseignants]);
    }

    public function gestionnaire_gestion_association_cours_enseignant($id){//liste des cours pour association
        $liste_cours = Cour::paginate(5);
        return view('comptes.gestionnaire.associations.gestionnaire_associer_cours_enseignant',['liste_cours'=>$liste_cours,'enseignant_id'=>$id]);
    }

    public function gestionnaire_gestion_asso_association_cours_enseignant($eid, $cid){//association
        $cours = Cour::findOrFail($cid);
        $enseignant = User::findOrFail($eid);

        $enseignant->cours()->attach($cours);

        return redirect()->route('gestionnaire.gestion.gestion_enseignants')->with('etat','L\'association a été effectué !');
    }

    public function gestionnaire_gestion_desassociation_cours_enseignant($id){//liste des cours pour desassociation
        $enseignant = User::findOrFail($id);
        $liste_cours = $enseignant->cours;

        return view('comptes.gestionnaire.associations.gestionnaire_desassocier_cours_enseignant',['liste_cours'=>$liste_cours,'enseignant_id'=>$id]);
    }

    public function gestionnaire_gestion_desa_desassociation_cours_enseignant($eid, $cid){//desassociation
        $enseignant = User::findOrFail($eid);
        $cours = Cour::findOrFail($cid);

        $enseignant->cours()->detach($cours);

        return redirect()->route('gestionnaire.gestion.gestion_enseignants')->with('etat','Le cours a été désassocié à l\'enseignant !');
    }

    public function gestionnaire_gestion_liste_cours_enseignants($id){//liste des enseignants associer au cours $id
        $cours = Cour::findOrFail($id);
        $liste_enseignants = $cours->users;

        return view('comptes.gestionnaire.associations.gestionnaire_liste_cours_enseignant',['liste_enseignants'=>$liste_enseignants,'cours'=>$cours]);
    }




}
