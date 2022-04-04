@extends('models.index_models')

@section('title','Page d\'authentification')

@section('content')

    <h1>S'authentifier</h1>
    <p>Voici le formulaire d'authentification :</p> 
    
    <form method="POST">
        @csrf
        Login: <input type="text" name="login" value="{{old('login')}}">
        MDP: <input type="password" name="mdp">
        <input type="submit" value="Envoyer">
    </form>
            
@endsection
