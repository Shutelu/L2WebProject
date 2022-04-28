@extends('models.index_models')

@section('title','Changement de mot de passe')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('user.page_mon_compte')}}">Retour</a><hr>

@endsection

@section('content')
    
    <h1>Formulaire de changement de mot de passe</h1>
    <p>Voulez-vous vraiment changer le mot de passe ?</p>

    <form method="POST">
        @csrf
        <label for="ancien">Ancien MDP</label>
        <input type="password" id="ancien" name="ancien">
        <br>
        <label for="mdp">MDP</label>
        <input type="password" id="mdp" name="mdp">
        <br>
        <label for="mdp_conf">Confirmation MDP</label>
        <input type="password" id="mdp_conf" name="mdp_confirmation">
        <br>
        <button type="submit">Changer le mot de passe</button>
    </form>

@endsection