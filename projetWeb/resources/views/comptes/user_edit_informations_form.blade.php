@extends('models.index_models')

@section('title','Edition des informations du compte')

@section('content')

    <h1>Edition des informations du compte</h1>

    <form method="POST">
        @csrf
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="{{$user->nom}}">
        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" value="{{$user->prenom}}">
        <button type="submit">Envoyer</button>
    </form>

    <a href="{{route('user.page_mon_compte')}}">Retour</a>

@endsection