@extends('models.index_models')

@section('title','Liste des présences détaillés')


@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Retour</a><br><br>
@endsection

@section('content')
    <h1>Liste des présences détaillée</h1>    
    <p>Description : Affichage de la liste des séances ou l'étudiant est présent</p>
    <p>L'étudiant (nom/prenom/noet): {{$etudiant->nom}} {{$etudiant->prenom}} {{$etudiant->noet}}</p>
    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Début</th>
            <th>Fin</th>
        </tr>
        @foreach ($liste_seances as $seance)
            <tr>
                <td>{{$seance->cour->intitule}}</td>
                <td>{{$seance->date_debut}}</td>
                <td>{{$seance->date_fin}}</td>
            </tr>
        @endforeach
    </table>
@endsection