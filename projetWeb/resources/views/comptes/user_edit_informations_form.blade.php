@extends('models.index_models')

@section('title','Edition des informations du compte')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('user.page_mon_compte')}}">Retour</a><hr>

@endsection

@section('content')

    <h1>Edition des informations du compte</h1>

    <form method="POST">
        @csrf
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="{{$user->nom}}">
        <br>
        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" value="{{$user->prenom}}">
        <br>
        <button type="submit">Envoyer</button>
    </form>

@endsection