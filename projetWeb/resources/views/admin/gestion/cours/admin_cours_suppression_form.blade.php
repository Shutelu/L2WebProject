@extends('models.index_models')

@section('title','Formulaire de suppression de cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('admin.cours.liste')}}">Retour</a>
@endsection

@section('content')
    <h1 class="colorful-h1">Formulaire de suppression de cours</h1>
    <p>Attention : Voulez-vous vraiment supprimer le cours : {{$cours->intitule}} ?</p>
    <form action="{{route('admin.cours.supprimer',['cid'=>$cours->id])}}" method="POST">
        @csrf
        <button type="submit">Supprimer</button>
    </form>
@endsection