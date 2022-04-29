@extends('models.index_models')

@section('title','Formulaire de modification')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Retour</a>
@endsection

@section('content')
    <h1 class="colorful-h1">Formulaire de modification</h1>
    <p>
        Attention : Le numero d'etudiant n'est pas modifiable. <br>
        Si un champ n'est pas remplie il ne sera pas pris en compte. <br>
        Si le nombre de caractere d'un champ est trop grand il ne sera pas pris en compte.
    
    </p>
    <form action="{{route('gestionnaire.etudiant.modifier',['eid'=>$etudiant->id])}}" method="POST">
        @csrf
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="{{$etudiant->nom}}"><br>
        <label for="prenom">Prenom</label>
        <input type="text" id="prenom" name="prenom" value="{{$etudiant->prenom}}"><br>

        <button type="submit">Modifier</button>
    </form>
@endsection