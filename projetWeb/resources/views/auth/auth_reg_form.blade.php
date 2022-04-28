@extends('models.index_models')

@section('title','Page d\'inscription')

@section('content')

    <h1>S'inscrire sur le site</h1>
    <p>Voici le formulaire d'inscription :</p> 
    <p>( *) : obligatoire</p>

    <form method="POST">
        @csrf
        <label for="nom">Nom* :</label>
        <input type="text" id="nom" name="nom" value="{{old('nom')}}">
        <br>
        <label for="prenom">Prenom* :</label>
        <input type="text" id="prenom" name="prenom" value="{{old('prenom')}}">
        <br>
        <label for="login">Login* :</label>
        <input type="text" id="login" name="login" value="{{old('login')}}">
        <br>
        <label for="mdp">MDP* :</label>
        <input type="password" id="mdp" name="mdp">
        <br>
        <label for="mdp_conf">Confirmation MDP* :</label>
        <input type="password" id="mdp_conf" name="mdp_confirmation">
        <br>
        <input type="submit" value="Envoyer">
    </form>
@endsection