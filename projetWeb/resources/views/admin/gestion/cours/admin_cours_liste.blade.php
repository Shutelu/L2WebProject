@extends('models.index_models')

@section('title','Liste des cours pour l\'administrateur')

@section('links')
    <link rel="stylesheet" href="/styles/admin_cours_style.css">
@endsection

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('admin.page_gestion')}}">Page de gestion</a>
    <hr style="border: 1px solid rgb(76, 186, 206);">

    <p>Recherche :</p>
    {{-- methode de recherche brut --}}
    <form action="{{route('admin.cours.cours_recherche')}}" method="POST">
        @csrf
        <input type="text" id="intitule" name="intitule" placeholder="Intitule"><br>
        <button type="submit">Rechercher</button>
        <hr>
        <a class="a_gestion_user_retour_listes" href="{{route('admin.cours.liste')}}">Revenir à la liste complète</a>
    </form>

@endsection

@section('content')
    <h1>Liste de tous les cours</h1>
    <p>Description : Vous êtes sur la liste de tous les cours disponible.</p>
    <br>
    <h3>Création d'un cours</h3>
    <form action="{{route('admin.cours.create')}}" method="POST">
        @csrf
        <label for="intitule">Veillez saisir l'Intitulé du cours (nom du cours) :</label>
        <input type="text" id="intitule" name="intitule">
        <button type="submit">Crée le cours</button>
    </form>
    {{-- <span id="admin_gestion_user_create"><a href="{{route('admin.gestion.cours_create_form')}}">Crée un cours</a></span> --}}
    <br>
    {{-- @foreach ($cours_liste as $cours)    
        <div class="cours-liste-box">
            <div class="cours-text-area">
                <p>Intitule : {{$cours->intitule}}</p>
                <p>Cree le : {{$cours->created_at}} </p>
                <p>modifier le : {{$cours->updated_at}}</p>
            </div>
            <div class="cours-button-area">
                <button>Modifier</button>
                <button>Supprimer</button>
                
            </div>
        </div>
    @endforeach --}}
    <br>
    <table class="table-affichage-donnee">
        <tr>
            <th>Intitulé</th>
            <th>Crée le</th>
            <th>Modifié le</th>
            <th>Actions</th>
        </tr>
        @foreach ($cours_liste as $cours)
            <tr>
                <td>{{$cours->intitule}}</td>
                <td>{{$cours->created_at}}</td>
                <td>{{$cours->updated_at}}</td>
                <td>
                    <form action="{{route('admin.cours.modification_form',['cid'=>$cours->id])}}" method="POST">
                        @csrf
                        <button type="submit">Modifier</button>
                    </form>
                    <form action="{{route('admin.cours.suppression_form',['cid'=>$cours->id])}}" method="POST">
                        @csrf
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection