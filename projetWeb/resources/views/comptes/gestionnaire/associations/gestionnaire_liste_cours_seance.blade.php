{{-- liste des enseignants associer a un cours --}}
@extends('models.index_models')

@section('title','Liste des séances associés à ce cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Retour</a><hr>

@endsection

@section('content')
    <h1>Liste des séances associés à ce cours</h1>
    <p>
        Description : Voici la liste des séances associés à ce cours : {{$cours->intitule}} <br>
        Pour procèder à la liste des présences, la modification ou la suppression veillez-vous rendre à la page Gestion Gestionnaire/Liste des seances de cours.
        <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_seances')}}">Accèder</a><hr>
    
    </p>

    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Debut</th>
            <th>Fin</th>

        </tr>
        @foreach ($liste_seances as $seance)
            <tr>
                <td>{{$cours->intitule}}</td>
                <td>{{$seance->date_debut}}</td>
                <td>{{$seance->date_fin}}</td>
            </tr>
        @endforeach
    </table>
@endsection