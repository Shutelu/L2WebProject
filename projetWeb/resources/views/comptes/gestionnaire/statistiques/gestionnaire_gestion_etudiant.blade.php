@extends('models.index_models')

@section('title','Gestion des etudiants')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.page_gestion')}}">Page de gestion gestionnaire</a><hr>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Liste des cours</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_seances')}}">Liste des séances</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_enseignants')}}">Liste des enseignants</a><br>
    <hr>
    <h2>Recherche : </h2>
    <form action="{{route('gestionnaire.gestion.filtrage_etudiants')}}" method="POST">
        @csrf
        <input type="text" id="nom" name="nom" placeholder="Nom">
        <input type="text" id="prenom" name="prenom" placeholder="Prenom">
        <input type="text" id="noet" name="noet"  placeholder="Numéro"><br>
        <button type="submit">Rechercher</button>
    </form>
    <hr>
    <p>
        Notice d'utilisation : <br>
         - Tout les champs de la recherche ne sont pas obligatoirement à saisir. <br>
         - Sensible à la casse (majuscule/minuscule).

    </p>
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
        @foreach ($etudiants_liste as $etudiant)
            <tr>
                <td>{{$etudiant->nom}}</td>
                <td>{{$etudiant->prenom}}</td>
                <td>{{$etudiant->noet}}</td>
                <td>{{$etudiant->created_at}}</td>
                <td>{{$etudiant->updated_at}}</td>
                <td>
                    <form action="{{route('gestionnaire.gestion.associer_etudiant_cours',['id'=>$etudiant->id])}}" method="POST">
                        @csrf
                        <button type="submit">Associer un cours</button>
                    </form>
                    <form action="{{route('gestionnaire.gestion.desassocier_etudiant_cours',['id'=>$etudiant->id])}}" method="POST">
                        @csrf
                        <button type="submit">Desassocier un cours</button>
                    </form>
                    <form action="{{route('gestionnaire.gestion.etudiant.liste_presence_detailler',['eid'=>$etudiant->id])}}" method="POST">
                        @csrf
                        <button>Liste de présence détaillée</button>
                    </form>
                    <form action="{{route('gestionnaire.etudiant.modification_form',['eid'=>$etudiant])}}" method="POST">
                        @csrf
                        <button>Modifier</button>
                    </form>
                    <form action="{{route('gestionnaire.etudiant.suppression_form',['eid'=>$etudiant])}}" method="POST">
                        @csrf
                        <button>Supprimer</button>
                    </form>

                </td>
            </tr>
        @endforeach
    </table>
    {{$etudiants_liste->links()}}
@endsection