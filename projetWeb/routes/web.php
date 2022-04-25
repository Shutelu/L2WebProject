<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CompteController;

/*
======================
    Page principale
======================
*/

//la route racine pour tout les utilisateurs
Route::get('/',[ProjectController::class,'pageIndex'])->name('pageIndex');

/*
==================================
    L'enregistrement de comptes
==================================
*/

//enregistrement des nouveaux utilisateurs
Route::get('/user_register',[RegisterUserController::class,'user_register_form'])->name('user.register_form');
Route::post('/user_register',[RegisterUserController::class,'user_register']);

/*
===============
    Le login
===============
*/

Route::get('/user_login',[AuthenticatedSessionController::class,'user_login_form'])->name('user.login_form');//voir authenticate(middleware) pour toute modif
Route::post('/user_login',[AuthenticatedSessionController::class,'user_login']);
Route::get('/user_logout',[AuthenticatedSessionController::class,'logout'])->middleware('auth')->name('logout');

/*
===============================
    Utilisateur authentifier
===============================
*/

//authentifier
Route::middleware(['auth'])->group(function(){

    //===== user authentifier =====
    Route::get('/user/mon_compte',[CompteController::class,'user_mon_compte'])->name('user.page_mon_compte');//accèder aux informations du compte
    Route::get('/user/mon_compte/edit_informations_form',[CompteController::class,'user_edit_informations_form'])->name('user.edit_informations_form');//formulaire d'édition des informations
    Route::post('/user/mon_compte/edit_informations_form',[CompteController::class,'user_edit_informations']);
    Route::get('/user/mon_compte/changer_mot_de_passe',[CompteController::class,'user_change_mdp_form'])->name('user.change_mdp_form');//formulaire de changement de mot de passe
    Route::post('/user/mon_compte/changer_mot_de_passe',[CompteController::class,'user_change_mdp']);
    
    //===== groupe enseignant =====
    Route::get('/enseignant/liste/cours_associer/{id}',[CompteController::class,'enseignant_liste_cours_associer'])->name('enseignant.page_gestion');//liste des cours associés
    Route::post('/enseignant/liste/{cid}/etudiants_inscrits_au_cours/{eid}',[CompteController::class,'enseignant_liste_inscrit_cours'])->name('enseignant.liste.inscrit_au_cours');//liste des inscrit
    Route::post('/enseignant/liste/{cid}/seances_de_ce_cours',[CompteController::class,'enseignant_liste_seances_cours'])->name('enseignant.liste.seances_ce_cours');//liste des seances de ce cours
    Route::post('/enseignant/liste/{cid}/etudiant_pour_cette_seance/{sid}',[CompteController::class,'enseignant_liste_etudiant_seance'])->name('enseignant_liste_etudiants_de_ce_seance');//liste des etudiants pour la seance
    Route::post('/enseignant/pointage/{cid}/seance_etudiant/{sid}/{eid}',[CompteController::class,'enseignant_pointage_seance_etudiant'])->name('enseignant.pointage.etudiant_seance');//pointage simple
    Route::post('/enseignant/liste/{cid}/presents_absents/{sid}',[CompteController::class,'enseignant_liste_presents_absents'])->name('enseignant_liste_present_absent');//liste present absent


    //===== groupe admin =====
    Route::middleware(['is_admin'])->group(function(){
        Route::get('/admin_index',[CompteController::class,'admin_index'])->name('admin.index');//accès page admin
        Route::get('/admin/page_de_gestion',[CompteController::class,'admin_page_gestion'])->name('admin.page_gestion');//accès page de gestion de l'admin
        Route::get('/admin/gestion/user_list',[CompteController::class,'admin_user_liste'])->name('admin.gestion.user_liste');//affichage liste des utilisateurs pour la gestion
        Route::post('/admin/gestion/user_list',[CompteController::class,'gestion_user_liste_filtrage'])->name('admin.gestion.user_liste_filtrage');//filtrage de la liste de utilisateur pour la gestion
        Route::post('/admin/gestion/user_recherche',[CompteController::class,'gestion_user_recherche'])->name('admin.gestion.user_recherche');//recherche
        Route::post('/admin/gestion/user_refus/{id}',[CompteController::class,'gestion_user_refus'])->name('admin.gestion.user_refus');//refuser une inscription
        Route::post('/admin/gestion/user_accepter_form/{id}',[CompteController::class,'gestion_user_accepter_form'])->name('admin.gestion.user_accepter_form');//formulaire acceptation
        Route::post('/admin/gestion/user_accepter/{id}',[CompteController::class,'gestions_user_accepter'])->name('admin.gestion.user_accepter');//fonction accepter
        Route::get('/admin/gestion/user_create_form',[CompteController::class,'gestions_user_create_form'])->name('admin.gestion.user_create_form');//formulaire creation user
        Route::post('/admin/gestion/user_create_form',[CompteController::class,'gestion_user_create']);// fonction creation user
        Route::get('/admin/gestion/cours_list',[CompteController::class,'gestion_cours_liste'])->name('admin.gestion.cours_liste');//affichage de la liste de cours
        Route::post('/admin/gestion/cours_list_create',[CompteController::class,'gestion_cours_create'])->name('admin.gestion.cours_create');//creation de cours
    });

    //===== groupe gestionnaire () =====
    Route::middleware(['is_gestionnaire'])->group(function(){//(ou admin)
        Route::get('/gestionnaire/page_de_gestion',[CompteController::class,'gestionnaire_page_gestion'])->name('gestionnaire.page_gestion');//page de gestion pour le gestionnaire
        Route::get('/gestionnaire/gestion_etudiants',[CompteController::class,'gestionnaire_gestion_etudiants'])->name('gestionnaire.gestion.gestion_etudiant');//liste de tout les etudiants
        Route::post('/gestionnaire/gestion/filtrage_etudiants',[CompteController::class,'gestionnaire_gestion_filtrage_etudiants'])->name('gestionnaire.gestion.filtrage_etudiants');

        Route::get('/gestionnaire/etudiant_create',[CompteController::class,'gestionnaire_create_etudiant_form'])->name('gestionnaire.gestion.create_etudiant_form');//formulaire de creation etudiant
        Route::post('/gestionnaire/etudiant_create',[CompteController::class,'gestionnaire_create_etudiant']);//fonction de creation etudiant

        //seance
        Route::get('/gestionnaire/gestion/liste/seance_de_ce_cours/{id}',[CompteController::class,'gestionnaire_seance_de_ce_cours'])->name('gestionnaire.gestion.liste_seance_de_ce_cours');//liste des seance d'un cours en particuliers
        Route::get('/gestionnaire/gestion/seances_de_cours',[CompteController::class,'gestionnaire_gestion_seances'])->name('gestionnaire.gestion.gestion_seances');//liste de tout les seances
        Route::get('/gestionnaire/gestion/seance_create/{id}',[CompteController::class,'gestionnaire_create_seance_form'])->name('gestionnaire.gestion.create_seances');//formulaire de creation de seances de cours
        Route::post('/gestionnaire/gestion/seance_create/{id}',[CompteController::class,'gestionnaire_create_seance'])->name('gestionnaire.gestion.create_seances');//fonction de creation de seance de cours
        Route::post('/gestionnaire/liste/seance/{sid}/presence_etudiant_par_seance',[CompteController::class,'gestionnaire_liste_presence_etudiant_par_seance'])->name('gestionnaire.liste.presence_etudiant_par_seance');
        Route::get('/gestionnaire/gestion/cours',[CompteController::class,'gestionnaire_gestion_cours'])->name('gestionnaire.gestion.gestion_cours');//liste des cours

        //etudiants
        Route::post('/gestionnaire/gestion/associer/{id}/etudiant_cours',[CompteController::class,'gestionnaire_gestion_association_cours_etudiant'])->name('gestionnaire.gestion.associer_etudiant_cours');//liste cours a associer
        Route::post('/gestionnaire/gestion/associer/{eid}/etudiant_cours/{cid}',[CompteController::class,'gestionnaire_gestion_asso_association_cours_etudiant'])->name('gestionnaire.gestion.associer.associer_etudiant_cours');//associer
        Route::post('/gestionnaire/gestion/desassocier/{id}/etudiant_cours',[CompteController::class,'gestionnaire_gestion_desassociation_cours_etudiant'])->name('gestionnaire.gestion.desassocier_etudiant_cours');//liste cours a desassocier
        Route::post('/gestionnaire/gestion/desassocier/{eid}/etudiant_cours/{cid}',[CompteController::class,'gestionnarie_gestion_desa_desassociation_cours_etudiant'])->name('gestionnaire.gestion.desassocier.desassocier_etudiant_cours');//desassocier
        Route::get('/gestionnaire/gestion/liste/cours_etudiants/{id}',[CompteController::class,'gestionnaire_gestion_liste_cours_etudiants'])->name('gestionnaire.gestion.liste_cours_etudiants');//liste des etudiants associer a un cours
        Route::post('/gestionnaire/gestion/etudiant/{eid}/liste/liste_presence_detailler',[CompteController::class,'gestionnaire_gestion_etudiant_liste_presence_detailler'])->name('gestionnaire.gestion.etudiant.liste_presence_detailler');

        //enseignants
        Route::get('/gestionnaire/gestion/liste/enseignants',[CompteController::class,'gestionnaire_gestion_liste_enseignants'])->name('gestionnaire.gestion.gestion_enseignants');//liste des enseignants
        Route::post('/gestionnaire/gestion/associer/{id}/enseignant_cours',[CompteController::class,'gestionnaire_gestion_association_cours_enseignant'])->name('gestionnaire.gestion.associer_enseignant_cours');//liste cours a associer
        Route::post('/gestionnaire/gestion/associer/{eid}/enseignant_cours/{cid}',[CompteController::class,'gestionnaire_gestion_asso_association_cours_enseignant'])->name('gestionnaire.gestion.associer.associer_enseignant_cours');//associer
        Route::post('/gestionnaire/gestion/desassocier/{id}/enseignant_cours',[CompteController::class,'gestionnaire_gestion_desassociation_cours_enseignant'])->name('gestionnaire.gestion.desassocier_enseignant_cours');//liste cours a desassocier
        Route::post('/gestionnaire/gestion/desassocier/{eid}/enseignant_cours/{cid}',[CompteController::class,'gestionnaire_gestion_desa_desassociation_cours_enseignant'])->name('gestionnaire.gestion.desassocier.desassocier_enseignant_cours');//desassocier
        Route::get('/gestionnaire/gestion/liste/cours_enseignants/{id}',[CompteController::class,'gestionnaire_gestion_liste_cours_enseignants'])->name('gestionnaire.gestion.liste_cours_enseignants');//liste dse enseignants associer a un cours
    });
});