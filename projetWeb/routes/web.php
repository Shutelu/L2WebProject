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
=======================
    L'enregistrement
=======================
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
============
    Admin
============
*/

Route::middleware(['auth','is_admin'])->group(function(){
    Route::get('/admin_index',[CompteController::class,'admin_index'])->name('admin.index');
});