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
    
    //===== groupe admin =====
    Route::middleware(['is_admin'])->group(function(){
        Route::get('/admin_index',[CompteController::class,'admin_index'])->name('admin.index');//accès page admin
        Route::get('/admin/page_de_gestion',[CompteController::class,'admin_page_gestion'])->name('admin.page_gestion');//accès page de gestion de l'admin
        Route::get('/admin/gestion/user_list',[CompteController::class,'admin_user_liste'])->name('admin.gestion.user_liste');//affichage liste des utilisateurs pour la gestion
        Route::post('/admin/gestion/user_list_filtre',[CompteController::class,'gestion_user_liste_filtrage'])->name('admin.gestion.user_liste_filtrage');//filtrage de la liste de utilisateur pour la gestion
        Route::post('/admin/gestion/user_recherche',[CompteController::class,'gestion_user_recherche'])->name('admin.gestion.user_recherche');
    });
});