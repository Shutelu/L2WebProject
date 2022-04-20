@extends('models.index_models')

@section('title','Liste des étudiants inscrits dans cette séances')

@section('outils')
    {{-- <a class="a_gestion_user_retour_listes" href="{{route('enseignant.page_gestion',['id'=>$enseignant_id])}}">Retour</a><hr> --}}
@endsection

@section('content')
    <h1>Liste des étudiant inscrits inscrit dans cette séances</h1>

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
                    <form action="{{route('enseignant.pointage.etudiant_seance',['cid'=>$cours->id,'sid'=>$seance_id,'eid'=>$etudiant->id])}}" method="POST">
                        @csrf
                        <button>Pointer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection