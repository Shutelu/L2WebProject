<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CompteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

Route::get('/user_login',[AuthenticatedSessionController::class,'user_login_form'])->name('user.login_form');
Route::post('/user_login',[AuthenticatedSessionController::class,'user_login']);
Route::get('/user_logout',[AuthenticatedSessionController::class,'logout'])->middleware('auth')->name('logout');

/*
===============================
    Utilisateur authentifier
===============================
*/

//authentifier
Route::middleware(['auth'])->group(function(){

    //user authentifier
    Route::get('/user/mon_compte',[CompteController::class,'user_mon_compte'])->name('user.page_mon_compte');//accèder aux informations du compte
    Route::get('/user/mon_compte/edit_informations_form',[CompteController::class,'user_edit_informations_form'])->name('user.edit_informations_form');//formulaire d'édition des informations
    Route::post('/user/mon_compte/edit_informations_form',[CompteController::class,'user_edit_informations']);
    Route::get('/user/mon_compte/changer_mot_de_passe',[CompteController::class,'user_change_mdp_form'])->name('user.change_mdp_form');//formulaire de changement de mot de passe
    Route::post('/user/mon_compte/changer_mot_de_passe',[CompteController::class,'user_change_mdp']);
    
    //groupe admin
    Route::middleware(['is_admin'])->group(function(){
        Route::get('/admin_index',[CompteController::class,'admin_index'])->name('admin.index');
    });
});