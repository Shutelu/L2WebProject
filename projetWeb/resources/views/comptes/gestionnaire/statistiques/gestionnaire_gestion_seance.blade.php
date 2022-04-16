{{-- page d'affichage de la liste des seances de cours --}}
@extends('models.index_models')

@section('title','Gestion des seances de cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.page_gestion')}}">Page de gestion gestionnaire</a><hr>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Liste des étudiants</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Liste des cours</a><br>
@endsection

@section('content')
    <h1>Gestion des séances de cours</h1>
    <p>Description : Vous êtes sur la liste de tout les séances de cours, cette liste facilitera vos operation. </p>

    <br>
    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.gestion_cours')}}">Ajouter une séance</a></span>
    <br>
    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Date de debut</th>
            <th>Date de fin</th>
        </tr>
        @foreach ($liste_seances as $ls)
            <tr>
                <td>{{$ls->cour->intitule}}</td>
                <td>{{$ls->date_debut}}</td>
                <td>{{$ls->date_fin}}</td>
            </tr>
        @endforeach
    </table>

    {{$liste_seances->links()}}
@endsection

