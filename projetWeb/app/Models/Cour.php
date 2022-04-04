<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cour;
use App\Models\Seance;
use App\Models\Etudiant;

class Cour extends Model
{
    use HasFactory;

    //relation 1:* coté principal
    public function seances(){
        return $this->hasMany(Seance::class);
    }

    //relation *:* avec user
    public function users(){
        return $this->belongsToMany(Cour::class);
    }

    //relation *:* avec etudiant
    public function etudiants(){
        return $this->belongsToMany(Etudiant::class);//pas de pivot
    }
}
