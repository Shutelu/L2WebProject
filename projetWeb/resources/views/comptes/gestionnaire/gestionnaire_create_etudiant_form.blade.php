@extends('models.index_models')

@section('title','Formulaire d\'ajout d\'un etudiant')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Revenir à la gestion des étudiants</a>
    <hr>
    <p>
        Notice d'utilisation : <br>
        Le numero de l'etudiant est remplie automatiquement (random) si il n'est pas renseigné. <br>
        <hr>
        * : champ obligatoire
    </p>
@endsection

@section('content')
    <h1>Formulaire d'ajout d'un(e) etudiant(e)</h1>

    <form action="">
        @csrf
        <label for="nom">Nom* :</label>
        <input type="text" id="nom" name="nom"><br>
        <label for="prenom">Prenom* :</label>
        <input type="text" id="prenom" name="prenom"><br>
        <label for="noet">Numero etudiant (8 chiffres):</label>
        <input type="number" id="noet" name="noet" min="10000000" max="99999999"><br>
        <button type="submit">Ajouter</button>
    </form>
@endsection