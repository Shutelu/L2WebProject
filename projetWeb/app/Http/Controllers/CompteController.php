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
                    = enseignant_liste_inscrit_cours(cid,eid)
                    = enseignant_liste_seances_cours(cid)
                    = enseignant_liste_etudiant_seance(cid,sid)
                    = enseignant_pointage_seance_etudiant(cid,sid,eid)
                    = enseignant_liste_presents_absents(cid,sid)
                Pour Admin :
                    = admin_index()
                    = admin_page_gestion()
                    # gestion des utilisateurs :
                        = admin_users_liste()
                        = admin_users_liste_filtrage(request)
                        = gestion_user_recherche(request)
                        = gestion_user_refus(id)
                        = gestion_user_accepter_form(id)
                        = gestions_user_accepter(request,id)
                        = gestions_user_create_form()
                        = gestion_user_create(request)
                        = etc
                    # gestion des cours :
                        = admin_cours_liste()
                        = admin_cours_create(request)
                        = admin_cours_recherche(request)
                        = admin_cours_modification_form(cid)
                        = admin_cours_modifier(request,cid)
                        = admin_cours_suppression_form(cid)
                        = admin_cours_supprimer(cid)
                Pour Gestionnaire :
                    = gestionnaire_page_gestion()
                    = gestionnaire_gestion_etudiants()
                    = gestionnaire_create_etudiant_form()
                    = gestionnaire_create_etudiant(request)
                    = gestionnaire_gestion_filtrage_etudiants(request)
                    = gestionnaire_gestion_seances()
                    = gestionnaire_create_seance_form(id)
                    = gestionnaire_create_seance(request,id)
                    = gestionnaire_gestion_cours()
                    = gestionnaire_seance_de_ce_cours(id)
                    = gestionnaire_gestion_association_cours_etudiant(id)
                    = gestionnaire_gestion_asso_association_cours_etudiant(eid,cid)
                    = gestionnaire_gestion_desassociation_cours_etudiant(id)
                    = gestionnarie_gestion_desa_desassociation_cours_etudiant(eid,cid)
                    = gestionnaire_gestion_liste_cours_etudiants(id)
                    = gestionnaire_gestion_etudiant_liste_presence_detailler(eid)
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

    public function enseignant_liste_inscrit_cours($cid, $eid){//liste des etudiants inscrit au cours 
        // $enseingnant = User::findOrFail
        $cours = Cour::findOrFail($cid);
        $liste_etudiants = $cours->etudiants;

        return view('comptes.enseignant.enseignant_liste_inscrit_cours',['liste_etudiants'=>$liste_etudiants,'enseignant_id'=>$eid,'cours'=>$cours]);
    }

    public function enseignant_liste_seances_cours($cid){//liste des seances de ce cours cid
        $cours = Cour::findOrFail($cid);
        $liste_seances = $cours->seances;

        return view('comptes.enseignant.enseignant_liste_seances_cours',['liste_seances'=>$liste_seances,'cours'=>$cours]);
    }

    public function enseignant_liste_etudiant_seance($cid,$sid){//liste des etudiants pour cette seance
        $cours = Cour::findOrFail($cid);
        $liste_etudiants = $cours->etudiants;

        return view('comptes.enseignant.enseignant_liste_etudiants_seance',['liste_etudiants'=>$liste_etudiants,'seance_id'=>$sid,'cours'=>$cours]);
    }

    public function enseignant_pointage_seance_etudiant($cid, $sid, $eid){//fonction de pointage seance et etudiant
        $cours = Cour::findOrFail($cid);
        $liste_etudiants = $cours->etudiants;

        $seance = Seance::findOrFail($sid);
        $etudiant = Etudiant::findOrFail($eid);

        //si existe deja
        if($seance->etudiants()->where('id','=',$eid)->first()){
            // dump($eid);
            // dd($seance->etudiants()->where('id','=',$eid)->first());
            session()->flash('etat','L\'étudiant(e) a deja été pointé(e) !');

            return view('comptes.enseignant.enseignant_liste_etudiants_seance',['liste_etudiants'=>$liste_etudiants,'seance_id'=>$sid,'cours'=>$cours]);
            // return redirect()->back()->with('etat','ok');// marche pas car get method not supported
            // return redirect()->route('enseignant_liste_etudiants_de_ce_seance',['cid'=>$cid,'sid'=>$seance->id])->with('etat','L\'étudiant(e) à été pointé (marqué présent(e)) pour cette séance !');
    
        }

        $seance->etudiants()->attach($etudiant);
        
        session()->flash('etat','L\'étudiant(e) à été pointé(e) (marqué présent(e)) pour cette séance !');
        return view('comptes.enseignant.enseignant_liste_etudiants_seance',['liste_etudiants'=>$liste_etudiants,'seance_id'=>$sid,'cours'=>$cours]);
        // return redirect()->route('enseignant_liste_etudiants_de_ce_seance',['cid'=>$cid,'sid'=>$seance->id])->with('etat','L\'étudiant(e) à été pointé (marqué présent(e)) pour cette séance !');
    }

    public function enseignant_liste_presents_absents($cid, $sid){//liste des presents absents
        $cours = Cour::findOrFail($cid);
        $seance = Seance::findOrFail($sid);

        $liste_etudiants = $cours->etudiants;
        $liste_presents = $seance->etudiants;//liste etudiant present
        // $tab = [];
        // $i = 0;
        // foreach($liste_presents as $present){
        //     $tab[$i] = $present;
        //     $i+=1;
        // }

        return view('comptes.enseignant.enseignant_liste_present_absent',['liste_etudiants'=>$liste_etudiants,'liste_presents'=>$liste_presents]);
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
    
    //gestion de utilisateurs :

    public function admin_users_liste(){//affichage de la liste de tout les utlisateurs (intégrale)
        $users_liste = User::paginate(5);
        $choix = 'defaut';
        return view('admin.gestion.utilisateurs.admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
    }

    public function admin_users_liste_filtrage(Request $request){//affichage de la liste des utilisateurs filtrer
        $request->validate([
            'filtreType' => 'required|in:defaut,enseignant,gestionnaire,admin'//"defaut" non utilisé mais doit etre present
        ]);

        $choix = $request->filtreType;

        if($request->filtreType == 'enseignant'){

            $users_liste = User::where('type','=','enseignant')->get();
            return view('admin.gestion.utilisateurs.admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
        else if($request->filtreType == 'gestionnaire'){

            $users_liste = User::where('type','=','gestionnaire')->get();
            return view('admin.gestion.utilisateurs.admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
        else if($request->filtreType == 'admin'){

            $users_liste = User::where('type','=','admin')->get();
            return view('admin.gestion.utilisateurs.admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
        }
        else{
            return redirect()->route('admin.users.liste');
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
            
            if(count($users_liste_verif) > 0){//si existe
                $choix = 'default';
                session()->flash('etat','La recherche a été accepté');
                return view('/admin/gestion/utilisateurs/admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
            }
            else{
                return redirect()->route('admin.users.liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) > 0 && strlen($request->prenom) == 0 && strlen($request->login) == 0){//seulement le nom est entre

            $users_liste = User::where('nom','=',$request->nom)->paginate(5);
            $users_liste_verif = User::where('nom','=',$request->nom)->get();

            if(count($users_liste_verif) > 0){
                $choix = 'default';
                session()->flash('etat','La recherche a été accepté');
                return view('/admin/gestion/utilisateurs/admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
            }
            else{
                return redirect()->route('admin.users.liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) == 0 && strlen($request->prenom) > 0 && strlen($request->login) == 0){//seulement le prenom est entre

            $users_liste = User::where('prenom','=',$request->prenom)->paginate(5);
            $users_liste_verif = User::where('prenom','=',$request->prenom)->get();

            if(count($users_liste_verif) > 0){//si existe
                $choix = 'default';
                session()->flash('etat','La recherche a été accepté');
                return view('/admin/gestion/utilisateurs/admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
            }
            else{
                return redirect()->route('admin.users.liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) == 0 && strlen($request->prenom) == 0 && strlen($request->login) > 0){//seulement le login est entre
            $users_liste = User::where('login','=',$request->login)->paginate(5);
            $users_liste_verif = User::where('login','=',$request->login)->get();

            if(count($users_liste_verif) > 0){//si existe
                $choix = 'default';
                session()->flash('etat','La recherche a été accepté');
                return view('/admin/gestion/utilisateurs/admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
            }
            else{
                return redirect()->route('admin.users.liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) > 0 && strlen($request->prenom) > 0 && strlen($request->login) == 0){//seulement nom et prenom
            $users_liste = User::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->paginate(5);
            $users_liste_verif = User::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->get();

            if(count($users_liste_verif) > 0){//si existe
                $choix = 'default';
                session()->flash('etat','La recherche a été accepté');
                return view('/admin/gestion/utilisateurs/admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
            }
            else{
                return redirect()->route('admin.users.liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) > 0 && strlen($request->prenom) == 0 && strlen($request->login) > 0){//seulement nom et login
            $users_liste = User::where('nom','=',$request->nom)->where('login','=',$request->login)->paginate(5);
            $users_liste_verif = User::where('nom','=',$request->nom)->where('login','=',$request->login)->get();

            if(count($users_liste_verif) > 0){//si existe
                $choix = 'default';
                session()->flash('etat','La recherche a été accepté');
                return view('/admin/gestion/utilisateurs/admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
            }
            else{
                return redirect()->route('admin.users.liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) == 0 && strlen($request->prenom) > 0 && strlen($request->login) > 0){//seulement prenom et login
            $users_liste = User::where('prenom','=',$request->prenom)->where('login','=',$request->login)->paginate(5);
            $users_liste_verif = User::where('prenom','=',$request->prenom)->where('login','=',$request->login)->get();

            if(count($users_liste_verif) > 0){//si existe
                $choix = 'default';
                session()->flash('etat','La recherche a été accepté');
                return view('/admin/gestion/utilisateurs/admin_user_liste',['users_liste'=>$users_liste,'choix'=>$choix]);
            }
            else{
                return redirect()->route('admin.users.liste')->with('etat','La recherche a rien aboutie');
            }
        }
        else{//rien est saisi pour la recherche
            return redirect()->route('admin.users.liste')->with('etat','Aucun information n\'a été entrée !');
        }
    }

    public function gestion_user_refus($id){//refus de la demander (suppression)
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('admin.users.liste')->with('etat','La demande de l\'utilisateur a été refuser, son compte a été supprimé !');
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
        
        return redirect()->route('admin.users.liste')->with('etat','L\'utilisateur a bien été accepté !');
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

        return redirect()->route('admin.users.liste')->with('etat','L\'utilisateur a été crée avec succès !');
    }

    
    public function admin_user_modification_form($uid){//formulaire de modification user
        $user = User::findOrFail($uid);
        return view('admin.gestion.utilisateurs.admin_user_modification_form',['user'=>$user]);
    }
    
    public function admin_user_modifier(Request $request, $uid){//fonction de mofif user
        //probleme de get method not supported
        // $check = Validator::make($request->all(),[
            //     'nom' => 'required|string|min:1|max:40',
            //     'prenom' => 'required|string|min:1|max:40',
            //     'login' => 'string|nullable|max:30|unique:users',
            //     'mdp' => 'confirmed|nullable|min:1|max:60',
            //     'typeSelect' => 'required|in:enseignant,gestionnaire,admin',
            // ]);
            $request->validate([
                'nom' => 'nullable|string|min:1|max:40',
                'prenom' => 'nullable|string|min:1|max:40',
                'login' => 'string|nullable|min:1|max:30|unique:users',
                'mdp' => 'confirmed|nullable|min:1|max:60',
                'typeSelect' => 'required|in:enseignant,gestionnaire,admin',
            ]);
            // if($check->fails()){
                //     return redirect()->back();
                // }
                
                $user = User::findOrFail($uid);
                if($request->nom != null){
                    $user->nom = $request->nom;
                }
        if($request->prenom != null){
            $user->prenom =$request->prenom;
        }
        if($request->login != null){
            $user->login = $request->login;
        }
        if($request->mdp != null){
            $user->mdp = Hash::make($request->mdp);
        }
        $user->type = $request->typeSelect;
        $user->save();
        
        return redirect()->route('admin.cours.liste')->with('etat','L\'utilisateur a été modifié !');
        // session()->flash('etat','L\'utilisateur a été modifié !');
        // return view('admin.gestion.utilisateurs.admin_user_liste');
    }
    
    public function admin_user_suppression_form($uid){
        $user = User::findOrFail($uid);
        return view('admin.gestion.utilisateurs.admin_user_supp_form',['user'=>$user]);
    }
    
    public function admin_user_supprimer($uid){
        $user = User::findOrFail($uid)->delete();
        return redirect()->route('admin.cours.liste')->with('etat','L\'Utilisateur a été supprimé !');
    }
    
    //gestion des cours :

    public function admin_cours_liste(){//affiche la liste des cours
        $cours_liste = Cour::all();
        return view('admin.gestion.cours.admin_cours_liste',['cours_liste'=>$cours_liste]);
    }

    public function admin_cours_create(Request $request){//cree un cours
        $request->validate([
            'intitule' => 'required|min:1|max:50'
        ]);

        $cours = new Cour();
        $cours->intitule = $request->intitule;
        $cours->save();

        return redirect()->route('admin.cours.liste')->with('etat',"Le cours de {$cours->intitule} a bien été crée !");
    }
    
    public function admin_cours_recherche(Request $request){//recherce un cours
        $request->validate([
            'intitule' => 'nullable|min:1|max:50|string',
        ]);
        
        if($request->intitule != null){
            $cours_liste = Cour::where('intitule','=',$request->intitule)->get();
            if(count($cours_liste) > 0){
                session()->flash('etat','Recherche effectuée !');
                return view('admin.gestion.cours.admin_cours_liste',['cours_liste'=>$cours_liste]);
            }
        }

        return redirect()->route('admin.cours.liste')->with('etat','La recherche n\'a rien aboutie !');
    }

    public function admin_cours_modification_form($cid){//formulaire de modification cours
        $cours = Cour::findOrFail($cid);

        return view('admin.gestion.cours.admin_cours_modification_form',['cours'=>$cours]);
    }

    public function admin_cours_modifier(Request $request, $cid){//fonction de modification cours
        $request->validate([
            'intitule' => 'nullable|string|min:1'
        ]);

        $cours = Cour::findOrFail($cid);
        if($request->intitule != null){
            //sinon avec max on a des erreurs
            if(strlen($request->intitule) <= 50){
                $cours->intitule = $request->intitule;
                $cours->save();
    
                return redirect()->route('admin.cours.liste')->with('etat',"L'intitule du cours a été modifié en {$cours->intitule} !");
            }
            return redirect()->route('admin.cours.liste')->with('etat',"Le champ saisi est supérieur à 50 aucune modification n'a eu lieu pour le cours : {$cours->intitule} ");
        }
        
        return redirect()->route('admin.cours.liste')->with('etat',"Le champ saisi est vide aucune modification n'a eu lieu pour le cours : {$cours->intitule} ");
    }

    public function admin_cours_suppression_form($cid){//formulaire de suppression cours
        $cours = Cour::findOrFail($cid);
        return view('admin.gestion.cours.admin_cours_suppression_form',['cours'=>$cours]);
    }

    public function admin_cours_supprimer($cid){//fonction de suppression cours
        $cours = Cour::findOrFail($cid)->delete();
        return redirect()->route('admin.cours.liste')->with('etat',"Le cours a été supprimé !");
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

    public function gestionnaire_gestion_filtrage_etudiants(Request $request){
        $request->validate([
            'nom' => 'max:40',
            'prenom' =>'max:40',
            'noet' => 'numeric|digits:8|nullable'//8 chiffres
        ]);

        //meme code que pour le filtrage des utilisateurs pour admin
        if(strlen($request->nom) > 0 && strlen($request->prenom) > 0 && strlen($request->noet) > 0){//tout les info sont entrees

            $etudiants_liste = Etudiant::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->where('noet','=',$request->noet)->paginate(5);
            $etudiants_liste_verif = Etudiant::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->where('noet','=',$request->noet)->get();//paginate ne permet pas le verif
            
            if(count($etudiants_liste_verif) > 0){//si existe
                session()->flash('etat','La recherche a été accepté');
                return view('/comptes/gestionnaire/statistiques/gestionnaire_gestion_etudiant',['etudiants_liste'=>$etudiants_liste]);
            }
            else{
                return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) > 0 && strlen($request->prenom) == 0 && strlen($request->noet) == 0){//seulement le nom est entre

            $etudiants_liste = Etudiant::where('nom','=',$request->nom)->paginate(5);
            $etudiants_liste_verif = Etudiant::where('nom','=',$request->nom)->get();

            if(count($etudiants_liste_verif) > 0){
                session()->flash('etat','La recherche a été accepté');
                return view('/comptes/gestionnaire/statistiques/gestionnaire_gestion_etudiant',['etudiants_liste'=>$etudiants_liste]);
            }
            else{
                return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) == 0 && strlen($request->prenom) > 0 && strlen($request->noet) == 0){//seulement le prenom est entre

            $etudiants_liste = Etudiant::where('prenom','=',$request->prenom)->paginate(5);
            $etudiants_liste_verif = Etudiant::where('prenom','=',$request->prenom)->get();

            if(count($etudiants_liste_verif) > 0){//si existe
                session()->flash('etat','La recherche a été accepté');
                return view('/comptes/gestionnaire/statistiques/gestionnaire_gestion_etudiant',['etudiants_liste'=>$etudiants_liste]);
            }
            else{
                return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) == 0 && strlen($request->prenom) == 0 && strlen($request->noet) > 0){//seulement le numero etudiant est entre
            $etudiants_liste = Etudiant::where('login','=',$request->noet)->paginate(5);
            $etudiants_liste_verif = Etudiant::where('login','=',$request->noet)->get();

            if(count($etudiants_liste_verif) > 0){//si existe
                session()->flash('etat','La recherche a été accepté');
                return view('/comptes/gestionnaire/statistiques/gestionnaire_gestion_etudiant',['etudiants_liste'=>$etudiants_liste]);
            }
            else{
                return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) > 0 && strlen($request->prenom) > 0 && strlen($request->noet) == 0){//seulement nom et prenom
            $etudiants_liste = Etudiant::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->paginate(5);
            $etudiants_liste_verif = Etudiant::where('nom','=',$request->nom)->where('prenom','=',$request->prenom)->get();

            if(count($etudiants_liste_verif) > 0){//si existe
                session()->flash('etat','La recherche a été accepté');
                return view('/comptes/gestionnaire/statistiques/gestionnaire_gestion_etudiant',['etudiants_liste'=>$etudiants_liste]);
            }
            else{
                return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) > 0 && strlen($request->prenom) == 0 && strlen($request->noet) > 0){//seulement nom et login
            $etudiants_liste = Etudiant::where('nom','=',$request->nom)->where('login','=',$request->noet)->paginate(5);
            $etudiants_liste_verif = Etudiant::where('nom','=',$request->nom)->where('login','=',$request->noet)->get();

            if(count($etudiants_liste_verif) > 0){//si existe
                session()->flash('etat','La recherche a été accepté');
                return view('/comptes/gestionnaire/statistiques/gestionnaire_gestion_etudiant',['etudiants_liste'=>$etudiants_liste]);
            }
            else{
                return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','La recherche a rien aboutie');
            }
        }
        else if(strlen($request->nom) == 0 && strlen($request->prenom) > 0 && strlen($request->noet) > 0){//seulement prenom et login
            $etudiants_liste = Etudiant::where('prenom','=',$request->prenom)->where('login','=',$request->noet)->paginate(5);
            $etudiants_liste_verif = Etudiant::where('prenom','=',$request->prenom)->where('login','=',$request->noet)->get();

            if(count($etudiants_liste_verif) > 0){//si existe
                session()->flash('etat','La recherche a été accepté');
                return view('/comptes/gestionnaire/statistiques/gestionnaire_gestion_etudiant',['etudiants_liste'=>$etudiants_liste]);
            }
            else{
                return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','La recherche a rien aboutie');
            }
        }
        else{//rien est saisi pour la recherche
            return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','Aucun information n\'a été entrée !');
        }
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

    public function gestionnaire_seance_de_ce_cours($id){//liste des seances du cours
        $cours = Cour::findOrFail($id);
        $liste_seances = $cours->seances;
        return view('/comptes/gestionnaire/associations/gestionnaire_liste_cours_seance',['cours'=>$cours,'liste_seances'=>$liste_seances]);
    }

    public function gestionnaire_gestion_association_cours_etudiant($id){//liste des cours pour association
        $liste_cours = Cour::paginate(5);
        return view('comptes.gestionnaire.associations.gestionnaire_associer_cours_etudiant',['liste_cours'=>$liste_cours,'etudiant_id'=>$id]);
    }

    public function gestionnaire_gestion_asso_association_cours_etudiant($eid,$cid){//association
        $cours = Cour::findOrFail($cid);
        $etudiant = Etudiant::findOrFail($eid);

        //si existe deja
        if($cours->etudiants()->where('id','=',$eid)->first()){
            return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','L\'association a déjà était effectué !');
        }
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

    public function gestionnaire_gestion_etudiant_liste_presence_detailler($eid){//liste presence detailler de l'etudiant
        $etudiant = Etudiant::findOrFail($eid);
        $liste_seance_present = $etudiant->seances;
        return view('comptes.gestionnaire.statistiques.gestionnaire_liste_etudiant_presence_detailler',['liste_seances'=>$liste_seance_present,'etudiant'=>$etudiant]);
    }

    public function gestionnaire_gestion_liste_enseignants(){//affichage liste des enseignants
        $liste_enseignants = User::where('type','=','enseignant')->paginate(5);
        return view('comptes.gestionnaire.statistiques.gestionnaire_gestion_liste_enseignants',['liste_enseignants'=>$liste_enseignants]);
    }

    public function gestionnaire_liste_presence_etudiant_par_seance($sid){//liste des etudiants present par seance
        $seance = Seance::findOrFail($sid);
        $liste_etudiants_present = $seance->etudiants;
        return view('comptes.gestionnaire.liste_des_presences.gestionnaire_liste_presence_par_seance',['liste_etudiants'=>$liste_etudiants_present,'seance'=>$seance]);
    }

    //Demander l'explication du prof pour le 2.6.3
    // public function gestionnaire_cours_liste_presence_etudiant($cid){
    //     $cours = Cour::findOrFail($cid);
    //     $liste_seances = $cours->seances;
    //     foreach($li){

    //     }
    //     $liste_etudiants_present = $cours->etudiant()->where()->get();
    // }

    public function gestionnaire_gestion_association_cours_enseignant($id){//liste des cours pour association
        $liste_cours = Cour::paginate(5);
        return view('comptes.gestionnaire.associations.gestionnaire_associer_cours_enseignant',['liste_cours'=>$liste_cours,'enseignant_id'=>$id]);
    }

    public function gestionnaire_gestion_asso_association_cours_enseignant($eid, $cid){//association
        $cours = Cour::findOrFail($cid);
        $enseignant = User::findOrFail($eid);

        //si existe deja
        if($cours->users()->where('id','=',$eid)->first()){
            return redirect()->route('gestionnaire.gestion.gestion_enseignants')->with('etat','L\'association a déjà était effectué !');
        }
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

    public function gestionnaire_etudiant_modification_form($eid){//formulaire de modification d'un etudiant
        $etudiant = Etudiant::findOrFail($eid);
        return view('comptes.gestionnaire.gestion_des_etudiants.gestionnaire_etudiant_modif_form',['etudiant'=>$etudiant]);
    }

    public function gestionnaire_etudiant_modifier(Request $request,$eid){//fonction de modification d'un etudiant
        $request->validate([
            'nom' => 'nullable|string|min:1|max:40',
            'prenom' => 'nullable|string|min:1|max:40',
        ]);
        
        $etudiant = Etudiant::findOrFail($eid);
        if($request->nom != null){
            $etudiant->nom = $request->nom;
        }
        if($request->prenom != null){
            $etudiant->prenom = $request->prenom;
        }
        $etudiant->save();

        return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','L\'étudiant(e) à été modifié(e)');

    }

    public function gestionnaire_etudiant_suppression_form($eid){//formulaire de suppression d'un etudiant
        $etudiant = Etudiant::findOrFail($eid);
        return view('comptes.gestionnaire.gestion_des_etudiants.gestionnaire_etudiant_supp_form',['etudiant'=>$etudiant]);
    }

    public function gestionnaire_etudiant_supprimer($eid){//fonction de suppresion d'un etudiant
        $etudiant = Etudiant::findOrFail($eid);
        $etudiant->delete();

        return redirect()->route('gestionnaire.gestion.gestion_etudiant')->with('etat','L\'étudiant(e) à été supprimé(e)');
    }

    public function gestionnaire_seance_modification_form($sid){//formulaire de modif seance
        $seance = Seance::findOrFail($sid);

        return view('comptes.gestionnaire.gestion_des_seances_de_cours.gestionnaire_seance_modif_form',['seance'=>$seance]);////icicicicicic
    }

    public function gestionnaire_seance_modifier(Request $request, $sid){//fonction modif seance
        $request->validate([
            'debut' => 'nullable|date|after:yesterday',
            'fin' => 'nullable|date|after:debut',
        ]);

        $seance = Seance::findOrFail($sid);
        if($request->debut != null){
            $seance->date_debut = $request->debut;
        }
        if($request->fin != null){
            $seance->date_fin = $request->fin;
        }
        $seance->save();

        return redirect()->route('gestionnaire.gestion.gestion_seances')->with('etat','La séance a été modifiée !');
    }

    public function gestionnaire_seance_suppression_form($sid){//formulaire supp seance
        return view('comptes.gestionnaire.gestion_des_seances_de_cours.gestionnaire_seance_supp_form',['sid'=>$sid]);
    }

    public function gestionnaire_seance_supprimer($sid){//fonction supp seance
        $seance  = Seance::findOrFail($sid)->delete();
        return redirect()->route('gestionnaire.gestion.gestion_seances')->with('etat','La séance a été supprimée !');
    }




}
