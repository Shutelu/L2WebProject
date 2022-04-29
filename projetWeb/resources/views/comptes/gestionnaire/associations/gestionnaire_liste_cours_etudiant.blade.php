{{-- liste des etudiant associer a un cours --}}
@extends('models.index_models')

@section('title','Liste des étudiant(e)s associés à ce cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Retour</a><hr>

@endsection

@section('content')
    <h1 class="colorful-h1">Liste des étudiant(e)s associés à ce cours</h1>
    <p>Description : Voici la liste des étudiants associé au cours : {{$cours->intitule}}</p>
    <table class="table-affichage-donnee">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Numéro étudiant</th>
            <th>Ajouté le</th>
            <th>Modifié le</th>

        </tr>
        @foreach ($liste_etudiants as $etudiant)
            <tr>
                <td>{{$etudiant->nom}}</td>
                <td>{{$etudiant->prenom}}</td>
                <td>{{$etudiant->noet}}</td>
                <td>{{$etudiant->created_at}}</td>
                <td>{{$etudiant->updated_at}}</td>
            </tr>
        @endforeach
    </table>
@endsection