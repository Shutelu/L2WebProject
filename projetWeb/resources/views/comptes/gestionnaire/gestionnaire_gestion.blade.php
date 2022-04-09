@extends('models.index_models')

@section('title','Page de gestion pour les gestionnaires')

@section('content')
    <h1>Options de gestion pour les gestionnaires :</h1>   
    <a href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Gestion des etudiants</a><br>
    <a href="">Gestion des seances de cours (void)</a><br>
    <a href="">Gestion des enseignants (void)</a><br>
@endsection