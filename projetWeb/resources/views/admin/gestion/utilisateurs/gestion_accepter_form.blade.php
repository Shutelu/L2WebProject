@extends('models.index_models')

@section('title','Formulaire d\'acceptation')

@section('outils')
    <a id="a_gestion_user_retour_listes" href="{{route('admin.gestion.user_liste')}}">Revenir à la liste completes</a>
@endsection

@section('content')
    <h1>Formulaire d'acceptation</h1>
    <p>
       <span style="text-decoration: underline">Voulez-vous accepté :</span> <br>
        Nom : {{$user->nom}} <br>
        Prenom : {{$user->prenom}} <br>
        Login : {{$user->login}}
    </p>
    <form action="{{route('admin.gestion.user_accepter',['id'=>$user->id])}}" method="POST">
        @csrf
        <label for="user_acceptation">Définissez le type de l'utilisateur pour pouvoir l'accepter :</label><br>
        <select name="userAcceptation" id="user_acceptation">
            {{-- <option selected disabled value="defaut">-- Choisir --</option> --}}
            <option value="enseignant">Enseignant</option>
            <option value="gestionnaire">Gestionnaire</option>
        </select>
        <br><br>
        <button type="submit">Accepter l'utilisateur</button>
    </form>
    <form action="{{route('admin.gestion.user_refus',['id'=>$user->id])}}" method="POST">
        @csrf
        <button type="submit">Refuser</button>
    </form>

@endsection