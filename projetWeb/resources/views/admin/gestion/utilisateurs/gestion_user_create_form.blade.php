@extends('models.index_models')

@section('title','Creation d\'un utilisateur')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('admin.gestion.user_liste')}}">Revenir à la liste completes</a>
@endsection

@section('outils')
    <p>
        Notice d'utilisation : <br>
        Vous avez la possibilité de crée une utilisateur en saisissent : le nom, le prenom, le login et le type <br>
        Le mot de passe sera par defaut "mdp" que l'utilisateur pourra changer de lui meme.
    </p>
@endsection

@section('content')
    <h1>Page de creation d'un utilisateur</h1>

    <form method="POST">
        @csrf
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="{{old('nom')}}"><br>
        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" value="{{old('prenom')}}"> <br>
        <label for="login">Login :</label>
        <input type="text" id="login" name="login" value="{{old('login')}}"> <br>
        <label for="mdp">MDP</label>
        <input type="password" id="mdp" name="mdp"> <br>
        <label for="mdp_conf">Confimation MDP</label>
        <input type="password" id="mdp_conf" name="mdp_confirmation"><br>
        <label for="type_select">Choisir un type</label>
        <select name="typeSelect" id="type_select"><br>
            <option value="enseignant">Enseignant</option>
            <option value="gestionnaire">Gestionnaire</option>
        </select><br>
        <button type="submit">Crée l'utilisateur</button>
    </form>
@endsection