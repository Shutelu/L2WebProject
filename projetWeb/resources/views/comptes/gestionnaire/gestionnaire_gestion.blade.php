@extends('models.index_models')

@section('title','Page de gestion pour les gestionnaires')

@section('content')
    <h1>Options de gestion pour les gestionnaires :</h1>   
    <h2>Statistiques</h2>
    <a href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Liste des étudiants</a><br>
    <a href="{{route('gestionnaire.gestion.gestion_cours')}}">Liste des cours</a> <br>
    <a href="{{route('gestionnaire.gestion.gestion_seances')}}">Liste des séances de cours</a><br>
    <a href="{{route('gestionnaire.gestion.gestion_enseignants')}}">Liste des enseignants</a><br>

    <br>

    <p>Buttons pour envoyer vers les ajouts</p>
    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.create_etudiant_form')}}">Ajouter un(e) étudiant(e)</a></span><br><br>
    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.gestion_cours')}}">Ajouter une séance de cours</a></span><br>

    <br>
    {{-- <h2>Mode d'emploi :</h2>
    <p>Texte</p> --}}
@endsection