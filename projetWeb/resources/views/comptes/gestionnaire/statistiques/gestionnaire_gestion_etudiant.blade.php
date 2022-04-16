@extends('models.index_models')

@section('title','Gestion des etudiants')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.page_gestion')}}">Page de gestion gestionnaire</a><hr>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Liste des cours</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_seances')}}">Liste des séances</a><br>
@endsection

@section('content')
    <h1>Gestion des etudiants</h1>
    <p>
        Description : Vous êtes sur la liste de tout les etudiants, cette liste facilitera vos operations.
    </p>

    <br>
    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.create_etudiant_form')}}">Ajouter un(e) étudiant(e)</a></span>
    <br>
    <table class="table-affichage-donnee">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Num etudiant</th>
            <th>Crée le</th>
            <th>Modifié le</th>
            <th>Actions</th>
        </tr>
        @foreach ($etudiants_liste as $el)
            <tr>
                <td>{{$el->nom}}</td>
                <td>{{$el->prenom}}</td>
                <td>{{$el->noet}}</td>
                <td>{{$el->created_at}}</td>
                <td>{{$el->updated_at}}</td>
                <td>modif/supp</td>
            </tr>
        @endforeach
    </table>
    {{$etudiants_liste->links()}}
@endsection