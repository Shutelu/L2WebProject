@extends('models.index_models')

@section('title','Page de gestion pour les gestionnaires')

@section('content')
    <h1 class="colorful-h1">Options de gestion pour les gestionnaires :</h1>   
    <h2>Statistiques</h2>
    <br>
    <a href="{{route('gestionnaire.gestion.gestion_etudiant')}}" class="colorful-link">Liste des étudiants</a>
    <br>
    <br>
    <a href="{{route('gestionnaire.gestion.gestion_cours')}}" class="colorful-link">Liste des cours</a> 
    <br>
    <br>
    <a href="{{route('gestionnaire.gestion.gestion_seances')}}" class="colorful-link">Liste des séances de cours</a>
    <br>
    <br>
    <a href="{{route('gestionnaire.gestion.gestion_enseignants')}}" class="colorful-link">Liste des enseignants</a>
    <br>
    <br>

    <p>Buttons pour envoyer vers les ajouts</p>
    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.create_etudiant_form')}}">Ajouter un(e) étudiant(e)</a></span><br><br>
    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.gestion_cours')}}">Ajouter une séance de cours</a></span><br>

    <br>
    <h2>Mode d'emploi :</h2>
    <p>
        Gestion des étudiants -> liste des étudiants
        <br>
        Gestion des séances de cours -> liste des séances de cours + liste des cours
        <br>
        Associations des étudiants -> liste des étudiants + liste des cours
    </p>

@endsection