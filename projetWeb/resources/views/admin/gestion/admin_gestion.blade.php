@extends('models.index_models')

@section('title','Page de gestion pour administrateur')

@section('content')
    <h1 class="colorful-h1">Options de gestion pour l'administrateur :</h1>

    {{-- ajout de css plus tard --}}
    <br>
    <a href="{{route('admin.users.liste')}}" class="colorful-link">Gestion des utilisateurs</a> 
    <br>
    <br>
    <a href="{{route('admin.cours.liste')}}" class="colorful-link">Gestion des cours</a>
@endsection