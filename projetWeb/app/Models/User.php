<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Cour;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //use SoftDeletes;//a voir avec le prof --> (pas de soft delete)

    public $timestamps = false; //enlever les dates

    protected $hidden = ['mdp']; //cacher mdp pour les controllers et vues

    protected $fillable = ['nom','prenom','login','mdp','type']; //constructeur

    protected $attributes = ['type' => null]; //type par defaut a null

    //renvoie le mdp
    public function getAuthPassword(){
        return $this->mdp;
    }

    //test si l'utilisateur est un admin
    public function isAdmin(){
        return $this->type == 'admin';
    }

    //si user est gestionnaire ou admin
    public function isGestionnaire(){
        return $this->type == 'gestionnaire' || $this->type == 'admin';
    }

    //relation *:* avec cour
    public function cours(){
        return $this->belongsToMany(Cour::class,'cours_users','user_id','cours_id');//pas de pivot
    }
}
