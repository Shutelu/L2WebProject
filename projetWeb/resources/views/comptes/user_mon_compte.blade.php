@extends('models.index_models')

@section('title','Ma page de compte')

@section('content')
    
    <h1 class="colorful-h1">Mon compte</h1>

    <br>
    <p style="font-size: 20px">
        
        Nom : {{$user->nom}}<br>
        Prenom : {{$user->prenom}}<br>
        Login : {{$user->login}}<br>
        Type : {{$user->type}}<br>
    </p>
    <a href="{{route('user.edit_informations_form')}}" class="colorful-link">Editer mes informations</a> 
    <br>
    <br>
    <a href="{{route('user.change_mdp_form')}}" class="colorful-link">Changer le mot de passe</a>
@endsection