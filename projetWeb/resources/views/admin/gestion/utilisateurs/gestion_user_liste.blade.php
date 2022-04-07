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
    <a id="a_gestion_user_retour_listes" href="{{route('admin.gestion.user_liste')}}">Revenir à la liste completes</a>
    <hr>
    <p>
        Notice d'utilisation : <br>
        Le filtrage et la recherche marche à part (chacun de son coté). <br>
        Tout les champs de la recherche ne sont pas obligatoirement à saisir.

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
        @foreach ($users_liste as $ul)
            <tr>
                <td>{{$ul->nom}}</td>
                <td>{{$ul->prenom}}</td>
                <td>{{$ul->login}}</td>
                <td>{{$ul->type}}</td>
                @if ($choix == 'defaut')
                    @if ($ul->type == null)
                        <td>
                            <form action="{{route('admin.gestion.user_accepter_form',['id'=>$ul->id])}}" method="POST">
                                @csrf
                                <button type="submit">Accepter</button>
                            </form>
                            <form action="{{route('admin.gestion.user_refus',['id'=>$ul->id])}}" method="POST">
                                @csrf
                                <button type="submit">Refuser</button>
                            </form>
                        </td>
                    @else
                        <td>Déjà accepté</td>
                    @endif   
                @endif

                @if ($ul->type == 'admin')
                    <td>Non disponible</td>
                @else
                    <td>modifier/supprimer</td>
                @endif
            </tr>
        @endforeach
    </table>
    {{$users_liste->links()}}
@endsection