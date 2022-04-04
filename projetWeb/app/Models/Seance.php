<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cour;
use App\Models\Etudiant;

class Seance extends Model
{
    use HasFactory;

    public $timestamps = false; //enlever les dates 

    // relation 1:* cote multiple
    public function cour(){
        return $this->belongsTo(User::class);
    }

    //relation *:* avec etudiant
    public function etudiants(){
        return $this->belongsToMany(Etudiant::class);
    }
}
