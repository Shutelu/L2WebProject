@extends('models.index_models')

@section('title','Formulaire de suppression')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_seances')}}">Retour</a>
@endsection

@section('content')
    <h1>Formulaire de suppression</h1>
    <p>Attention : Voulez-vous vraiment supprimer la séance ?</p>
    <form action="{{route('gestionnaire.seance.supprimer',['sid'=>$sid])}}" method="POST">
        @csrf
        <button type="submit">Supprimer</button>
    </form>
@endsection