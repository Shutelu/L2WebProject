@extends('models.index_models')

@section('title','Liste des utilisateurs pour l\'administrateur')

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

    {{-- options de filtrage --}}
    <form action="{{route('admin.gestion.user_liste_filtrage')}}"  method="GET">
        @csrf
        <label for="filtre">Filtrage par type :</label>
        <select name="filtreType" id="filtre-type">
            <option value="defaut">Défaut</option>
            <option value="enseignant">Enseignant</option>
            <option value="gestionnaire">Gestionnaire</option>
        </select>
        <button type="submit">Filtrer</button>
    </form>

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
                        <td>Accepter/refuser</td>
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
@endsection