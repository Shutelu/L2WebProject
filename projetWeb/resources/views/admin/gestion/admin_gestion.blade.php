@extends('models.index_models')

@section('title','Page de gestion pour administrateur')

@section('content')
    <h1>Options de gestion pour l'administrateur :</h1>

    {{-- ajout de css plus tard --}}
    <a href="{{route('admin.gestion.user_liste')}}">Gestion des utilisateurs</a> <br>
    <a href="{{route('admin.gestion.cours_liste')}}">Gestion des cours (en cours de construction)</a>
@endsection