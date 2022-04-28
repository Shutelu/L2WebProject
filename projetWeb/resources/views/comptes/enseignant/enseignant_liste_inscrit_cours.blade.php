@extends('models.index_models')

@section('title','Liste des inscrit à ce cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('enseignant.page_gestion',['id'=>$enseignant_id])}}">Retour</a><hr>
@endsection

@section('content')
    <h1>Liste des étudiant inscrits dans ce cours</h1>

    <p>Description : Vous etes sur le cours de : {{$cours->intitule}}</p>
    <table class="table-affichage-donnee">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Numéro</th>
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