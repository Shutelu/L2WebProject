@extends('models.index_models')

@section('title','Page de gestion pour les gestionnaires')

@section('content')
    <h1>Options de gestion pour les gestionnaires :</h1>   
    <h2>Statistiques</h2>
    <a href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Liste des étudiants</a><br>
    <a href="{{route('gestionnaire.gestion.gestion_cours')}}">Liste des cours</a> <br>
    <a href="{{route('gestionnaire.gestion.gestion_seances')}}">Liste des séances de cours</a><br>
    <a href="">Gestion des enseignants (void)</a><br>

    <br>

    <p>Buttons pour envoyer vers les ajouts</p>
@endsection