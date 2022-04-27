@extends('models.index_models')

@section('title','Page de gestion pour administrateur')

@section('content')
    <h1>Options de gestion pour l'administrateur :</h1>

    {{-- ajout de css plus tard --}}
    <a href="{{route('admin.users.liste')}}">Gestion des utilisateurs</a> <br>
    <a href="{{route('admin.cours.liste')}}">Gestion des cours</a>
@endsection