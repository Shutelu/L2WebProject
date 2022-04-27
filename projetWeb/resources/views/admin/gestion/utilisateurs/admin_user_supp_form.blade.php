@extends('models.index_models')

@section('title','Formulaire de suppression')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('admin.gestion.user_liste')}}">Retour</a>
@endsection

@section('content')
    <h1>Formulaire de suppression</h1>
    <p>Attention : Voulez-vous vraiment supprimer l'utilisateur : {{$user->nom}} {{$user->prenom}} {{$user->login}} ?</p>
    <form action="{{route('admin.user.supprimer',['uid'=>$user->id])}}" method="POST">
        @csrf
        <button type="submit">Supprimer</button>
    </form>
@endsection