<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cour;
use App\Models\Etudiant;

class Seance extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $dates = ['date_debut','date_fin'];

    

    // relation 1:* cote multiple
    public function cour(){
        return $this->belongsTo(Cour::class,'cours_id');//pas de pivot
    }

    //relation *:* avec etudiant
    public function etudiants(){
        return $this->belongsToMany(Etudiant::class);
    }
}
