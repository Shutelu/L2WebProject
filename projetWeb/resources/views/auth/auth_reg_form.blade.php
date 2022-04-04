@extends('models.index_models')

@section('title','Page d\'inscription')

@section('content')

    <h1>S'inscrire sur le site</h1>
    <p>Voici le formulaire d'inscription :</p> 

    <form method="POST">
        @csrf
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="{{old('nom')}}">
        Prenom: <input type="text" name="prenom" value="{{old('prenom')}}">
        Login: <input type="text" name="login" value="{{old('login')}}">
        MDP: <input type="password" name="mdp">
        Confirmation MDP: : <input type="password" name="mdp_confirmation">
        <input type="submit" value="Envoyer">
    </form>
@endsection