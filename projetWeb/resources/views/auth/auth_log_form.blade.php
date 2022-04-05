@extends('models.index_models')

@section('title','Page d\'authentification')

@section('content')

    <h1>S'authentifier</h1>
    <p>Voici le formulaire d'authentification :</p> 
    
    <form method="POST">
        @csrf
        <label for="login">Login :</label>
        <input type="text" id="login" name="login" value="{{old('login')}}">
        <label for="mdp">MDP :</label>
        <input type="password" id="mdp" name="mdp">
        <input type="submit" value="Envoyer">
    </form>
            
@endsection
