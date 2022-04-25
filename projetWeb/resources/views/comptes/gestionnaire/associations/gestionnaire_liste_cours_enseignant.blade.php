{{-- liste des enseignants associer a un cours --}}
@extends('models.index_models')

@section('title','Liste des enseignants associés à ce cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Retour</a><hr>

@endsection

@section('content')
    <h1>Liste des enseignants associés à ce cours</h1>
    <p>Description : Voici la liste des enseignants associés à ce cours : {{$cours->intitule}}</p>
    <table class="table-affichage-donnee">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>

        </tr>
        @foreach ($liste_enseignants as $enseignant)
            <tr>
                <td>{{$enseignant->nom}}</td>
                <td>{{$enseignant->prenom}}</td>
            </tr>
        @endforeach
    </table>
@endsection