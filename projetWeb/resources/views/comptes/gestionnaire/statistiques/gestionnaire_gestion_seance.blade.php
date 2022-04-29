{{-- page d'affichage de la liste des seances de cours --}}
@extends('models.index_models')

@section('title','Gestion des seances de cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.page_gestion')}}">Page de gestion gestionnaire</a><hr>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Liste des étudiants</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Liste des cours</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_enseignants')}}">Liste des enseignants</a><br>
@endsection

@section('content')
    <h1 class="colorful-h1">Gestion des séances de cours</h1>
    <p>Description : Vous êtes sur la liste de tout les séances de cours, cette liste facilitera vos operation. </p>

    <br>
    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.gestion_cours')}}">Ajouter une séance de cours</a></span>
    <br>
    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Date de debut</th>
            <th>Date de fin</th>
            <th>Action</th>
        </tr>
        @foreach ($liste_seances as $seance)
            <tr>
                <td>{{$seance->cour->intitule}}</td>
                <td>{{$seance->date_debut}}</td>
                <td>{{$seance->date_fin}}</td>
                <td>
                    <form action="{{route('gestionnaire.liste.presence_etudiant_par_seance',['sid'=>$seance->id])}}" method="POST">
                        @csrf
                        <button>Liste des présences</button>
                    </form>
                    <form action="{{route('gestionnaire.seance.modification_form',['sid'=>$seance->id])}}" method="POST">
                        @csrf
                        <button>Modifier</button>
                    </form>
                    <form action="{{route('gestionnaire.seance.suppression_form',['sid'=>$seance->id])}}" method="POST">
                        @csrf
                        <button>Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{$liste_seances->links()}}
@endsection

