@extends('models.index_models')

@section('title','Liste des enseignants')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.page_gestion')}}">Page de gestion gestionnaire</a><hr>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Liste des étudiants</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Liste des cours</a><br><br>
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_seances')}}">Liste des séances</a><br>
@endsection

@section('content')
    <h1>Liste des enseignants</h1>
    <table class="table-affichage-donnee">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Actions</th>
        </tr>

        @foreach ($liste_enseignants as $enseignant)
            <tr>
                <td>{{$enseignant->nom}}</td>
                <td>{{$enseignant->prenom}}</td>
                <td>
                    <form action="{{route('gestionnaire.gestion.associer_enseignant_cours',['id'=>$enseignant->id])}}" method="POST">
                        @csrf
                        <button type="submit">Associer un cours</button>
                    </form>
                    <form action="{{route('gestionnaire.gestion.desassocier_enseignant_cours',['id'=>$enseignant->id])}}" method="POST">
                        @csrf
                        <button type="submit">Desassocier un cours</button>
                    </form>
                    {{-- <form action="" method="POST">
                        @csrf
                        <button>Modifier</button>
                    </form>
                    <form action="">
                        @csrf
                        <button>Supprimer</button>
                    </form> --}}
                </td>
            </tr>
        @endforeach

    </table>
    {{$liste_enseignants->links()}}
@endsection