@extends('models.index_models')

@section('title','Liste des cours pour l\'administrateur')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.page_gestion')}}">Page de gestion gestionnaire</a><hr>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Liste des étudiants</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_seances')}}">Liste des séances</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_enseignants')}}">Liste des enseignants</a><br>
@endsection

@section('content')
    <h1>Liste de tous les cours</h1>
    <p>Description : Vous êtes sur la liste de tous les cours disponibles</p>
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
                    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.create_seances',['id'=>$lc->id])}}">Ajouter une séance</a></span><br><br>
                    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.liste_seance_de_ce_cours',['id'=>$lc->id])}}">Liste de séance pour ce cours</a></span><br><br>
                    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.liste.presence_etudiant_par_cours',['cid'=>$lc->id])}}">Liste des présences</a></span><br><br>
                    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.liste_cours_etudiants',['id'=>$lc->id])}}">Liste des etudiants associés à ce cours</a></span><br><br>
                    <span class="admin_gestion_user_create"><a href="{{route('gestionnaire.gestion.liste_cours_enseignants',['id'=>$lc->id])}}">Liste des enseignants associés à ce cours</a></span>
                </td>
            </tr>
        @endforeach
    </table>
    {{$liste_cours->links()}}
@endsection