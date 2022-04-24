@extends('models.index_models')

@section('title','Liste des séances de ce cours')

@section('outils')
    {{-- <a class="a_gestion_user_retour_listes" href="{{route('enseignant.page_gestion',['id'=>$enseignant_id])}}">Retour</a><hr> --}}
@endsection

@section('content')
    <h1>Liste des séances de ce cours</h1>

    <p>
        Description : Vous etes sur le cours de : {{$cours->intitule}} <br>
        Vous allez pouvoir faire le pointage des étudiants ici.
    </p>
    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Date de debut</th>
            <th>Date de fin</th>
            <th>Actions</th>
        </tr>
        @foreach ($liste_seances as $seance)
            <tr>
                <td>{{$seance->cour->intitule}}</td>
                <td>{{$seance->date_debut}}</td>
                <td>{{$seance->date_fin}}</td>
                <td>
                    <form action="{{route('enseignant_liste_etudiants_de_ce_seance',['cid'=>$cours->id,'sid'=>$seance->id])}}" method="post">
                        @csrf
                        <button type="submit">Pointage simple des étudiants pour cette séance</button>
                    </form>
                    <form action="" method="POST">
                        @csrf
                        <button type="submit">Pointage multiple des étudiants pour cette séance</button>
                    </form>
                    <form action="{{route('enseignant_liste_present_absent',['cid'=>$cours->id,'sid'=>$seance->id])}}" method="POST">
                        @csrf
                        <button type="submit">Liste des presents/absents</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection