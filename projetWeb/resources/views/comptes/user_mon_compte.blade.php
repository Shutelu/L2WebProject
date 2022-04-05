@extends('models.index_models')

@section('title','Ma page de compte')

@section('content')
    
    <h1>Mon compte</h1>

    <p>
        Nom : {{$user->nom}}<br>
        Prenom : {{$user->prenom}}<br>
        Login : {{$user->login}}<br>
        Type : {{$user->type}}<br>
    </p>
    <a href="{{route('user.edit_informations_form')}}">Editer mes informations</a> <br>
    <a href="{{route('user.change_mdp_form')}}">Changer le mot de passe</a>
@endsection