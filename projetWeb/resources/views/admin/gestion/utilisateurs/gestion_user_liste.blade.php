@extends('models.index_models')

@section('title','Liste des utilisateurs pour l\'administrateur')

@section('outils')
    <h2>Outils d'édition</h2>
    <hr style="border: 1px solid rgb(76, 186, 206);">
    {{-- options de filtrage --}}
    <form action="{{route('admin.gestion.user_liste_filtrage')}}"  method="POST">
        @csrf
        <label for="filtre">Filtrage par type :</label><br>
        <select name="filtreType" id="filtre-type">
            <option value="defaut">Défaut</option>
            <option value="enseignant">Enseignant</option>
            <option value="gestionnaire">Gestionnaire</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Filtrer</button>
    </form>
    <hr>
    <p>Recherche :</p>
    {{-- methode de recherche brut --}}
    <form action="{{route('admin.gestion.user_recherche')}}" method="POST">
        @csrf
        <input type="text" id="nom" name="nom" placeholder="Nom">
        <input type="text" id="prenom" name="prenom" placeholder="Prenom">
        <input type="text" id="login" name="login"  placeholder="Login"><br>
        <button type="submit">Rechercher</button>
    </form>
    <hr>
    <a class="a_gestion_user_retour_listes" href="{{route('admin.gestion.user_liste')}}">Revenir à la liste completes</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('admin.page_gestion')}}">Page de gestion admin</a>
    <hr>
    <p>
        Notice d'utilisation : <br>
         - Le filtrage et la recherche marche à part (chacun de son coté). <br>
         - Tout les champs de la recherche ne sont pas obligatoirement à saisir. <br>
         - Sensible à la casse (majuscule/minuscule).

    </p>
    
@endsection

@section('content')

    {{-- choix pour le titre --}}
    <h1>Liste de tout les utilisateurs
        @if ($choix == 'gestionnaire')
            Gestionnaire
        @endif
        @if ($choix == 'enseignant')
            Enseignant
        @endif
    </h1>

    {{-- choix pour la description --}}
    @if ($choix == 'defaut')
        <p>Description : Affichage de la liste des utilisateurs intégrale, permet l'acceptation ou le refus <br>
        ainsi que la modification et la suppression d'un utilisateur (non disponible pour la modification ou suppression d'un autre administrateur)</p>
    @endif
    @if ($choix == 'gestionnaire')
        <p>Description : Affichage de la liste de tout les gestionnaires</p>
    @endif
    @if ($choix == 'enseignant')
        <p>Description : Affichage de la liste de tout les enseignants</p>
    @endif
    {{-- br temporaire a remplacer par du css --}}
    <br>
    <span class="admin_gestion_user_create"><a href="{{route('admin.gestion.user_create_form')}}">Crée un utilisateur</a></span>
    <br>
    {{-- affichage des données --}}
    <table  class="table-affichage-donnee">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Login</th>
            <th>Type</th>
            @if ($choix == 'defaut')
                <th>Acceptation</th>
            @endif
            <th>Actions</th>
        </tr>
        @foreach ($users_liste as $user)
            <tr>
                <td>{{$user->nom}}</td>
                <td>{{$user->prenom}}</td>
                <td>{{$user->login}}</td>
                <td>{{$user->type}}</td>
                @if ($choix == 'defaut')
                    @if ($user->type == null)
                        <td>
                            <form action="{{route('admin.gestion.user_accepter_form',['id'=>$user->id])}}" method="POST">
                                @csrf
                                <button type="submit">Accepter</button>
                            </form>
                            <form action="{{route('admin.gestion.user_refus',['id'=>$user->id])}}" method="POST">
                                @csrf
                                <button type="submit">Refuser</button>
                            </form>
                        </td>
                    @else
                        <td>Déjà accepté</td>
                    @endif   
                @endif

                <td>
                    <form action="{{route('admin.user.modification_form',['uid'=>$user->id])}}" method="POST">
                        @csrf
                        <button type="submit">Modifier</button>
                    </form>
                    <form action="{{route('admin.user.suppression_form',['uid'=>$user->id])}}" method="POST">
                        @csrf
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    @if ($choix == 'defaut')
        {{$users_liste->links()}}
        
    @endif
@endsection