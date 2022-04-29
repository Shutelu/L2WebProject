@extends('models.index_models')

@section('title','Formulaire d\'acceptation')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('admin.users.liste')}}">Revenir à la liste completes</a>
@endsection

@section('content')
    <h1 class="colorful-h1">Formulaire d'acceptation</h1>
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
        <button type="submit" id="colorful_button_ajout">Accepter l'utilisateur</button>
    </form>
    <br>
    <form action="{{route('admin.gestion.user_refus',['id'=>$user->id])}}" method="POST">
        @csrf
        <button type="submit" id="colorful_button_refus">Refuser</button>
    </form>

@endsection