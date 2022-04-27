@extends('models.index_models')

@section('title','Formulaire de modification')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('admin.gestion.user_liste')}}">Retour</a>
@endsection

@section('content')
    <h1>Formulaire de modification</h1>
    <p>
        Attention : Le login est unique, ne pas mettre l'ancienne valeur. <br>
        Si un champ n'est pas remplie il ne sera pas pris en compte.
    </p>
    <p>Login de l'utilisateur : {{$user->login}}</p>

    <form action="{{route('admin.user.modifier',['uid'=>$user->id])}}" method="POST">
        @csrf
        <label for="nom">Nom : </label>
        <input type="text" id="nom" name="nom" value="{{$user->nom}}"><br>
        <label for="prenom">Prenom : </label>
        <input type="text" id="prenom" name="prenom" value="{{$user->prenom}}"><br>
        <label for="login">Login : </label>
        <input type="text" id="login" name="login"><br>
        <label for="mdp">MDP : </label>
        <input type="password" id="mdp" name="mdp">
        <label for="mdp_conf">MDP Confirmation : </label>
        <input type="password" id="mdp_conf" name="mdp_confirmation"><br>
        <label for="">Choisir un nouveau type : </label>
        <select name="typeSelect" id="type">
            <option value="enseignant">Enseignant</option>
            <option value="gestionnaire">Gestionnaire</option>
            <option value="admin">Admin</option>
        </select>
        <br>

        <button type="submit">Modifier</button>
    </form>
@endsection