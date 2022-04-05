@extends('models.index_models')

@section('title','Page d\'inscription')

@section('content')

    <h1>S'inscrire sur le site</h1>
    <p>Voici le formulaire d'inscription :</p> 

    <form method="POST">
        @csrf
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="{{old('nom')}}">
        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" value="{{old('prenom')}}">
        <label for="login">Login :</label>
        <input type="text" id="login" name="login" value="{{old('login')}}">
        <label for="mdp">MDP :</label>
        <input type="password" id="mdp" name="mdp">
        <label for="mdp_conf">Confirmation MDP :</label>
        <input type="password" id="mdp_conf" name="mdp_confirmation">
        <input type="submit" value="Envoyer">
    </form>
@endsection