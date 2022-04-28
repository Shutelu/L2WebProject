@extends('models.index_models')

@section('title','Liste des étudiants inscrits dans cette séances')

@section('outils')
    <form action="{{route('enseignant.liste.seances_ce_cours',['cid'=>$cours->id,'eid'=>$enseignant_id])}}" method="POST">
        @csrf
        <button class="a_gestion_user_retour_listes">Retour</button>
    </form>
@endsection

@section('content')
    <h1>Liste des étudiant inscrits dans cette séances</h1>

    <p>Description : Vous etes sur le séance de : {{$cours->intitule}}</p>
    <table class="table-affichage-donnee">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Numéro</th>
            <th>Pointage</th>
        </tr>
        @foreach ($liste_etudiants as $etudiant)
            <tr>
                <td>{{$etudiant->nom}}</td>
                <td>{{$etudiant->prenom}}</td>
                <td>{{$etudiant->noet}}</td>
                <td>
                    <form action="{{route('enseignant.pointage.etudiant_seance',['cid'=>$cours->id,'sid'=>$seance_id,'eid'=>$etudiant->id,'eeid'=>$enseignant_id])}}" method="POST">
                        @csrf
                        <button>Pointer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection