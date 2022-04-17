@extends('models.index_models')

@section('title','Liste des cours pour l\'administrateur')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.page_gestion')}}">Page de gestion gestionnaire</a><hr>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Liste des étudiants</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_seances')}}">Liste des séances</a><br>
@endsection

@section('content')
    <h1>Liste de tout les cours</h1>
    <p>Description : Vous êtes sur la liste de tout les cours disponibles</p>
    <br>
    
    {{-- <span id="admin_gestion_user_create"><a href="{{route('admin.gestion.cours_create_form')}}">Crée un cours</a></span> --}}
    <br>
    <table class="table-affichage-donnee">
        <tr>
            <th>Intitulé</th>
            <th>Crée le</th>
            <th>Modifié le</th>
            <th>Actions</th>
        </tr>
        @foreach ($liste_cours as $lc)
            <tr>
                <td>{{$lc->intitule}}</td>
                <td>{{$lc->created_at}}</td>
                <td>{{$lc->updated_at}}</td>
                <td>
                    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.create_seances',['id'=>$lc->id])}}">Ajouter une séance</a></span><br>
                    liste des etudiants associe a ce cours(lien)
                </td>
            </tr>
        @endforeach
    </table>
@endsection