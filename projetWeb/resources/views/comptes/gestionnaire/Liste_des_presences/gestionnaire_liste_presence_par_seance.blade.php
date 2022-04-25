@extends('models.index_models')

@section('title','Liste des présences à cette séance')


@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_seances')}}">Retour</a><br><br>
@endsection

@section('content')
    <h1>Liste des présences à cette séance</h1>    
    <p>Description : Affichage de la liste des étudiants présent à cette séances</p>
    <p>Seance de : {{$seance->cour->intitule}}</p>
    <table class="table-affichage-donnee">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Numéro étudiant</th>
        </tr>
        @foreach ($liste_etudiants as $etudiant)
            <tr>
                <td>{{$etudiant->nom}}</td>
                <td>{{$etudiant->prenom}}</td>
                <td>{{$etudiant->noet}}</td>
            </tr>
        @endforeach
    </table>
@endsection