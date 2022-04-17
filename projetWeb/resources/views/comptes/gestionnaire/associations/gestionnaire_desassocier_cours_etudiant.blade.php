@extends('models.index_models')

@section('tilte','Désassociation étudiant cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_etudiant')}}">Retour</a><hr>

@endsection

@section('content')
    <h1>Désassociation étudiant cours</h1>

    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Action</th>
        </tr>

        @foreach ($liste_cours as $cours)
            <tr>
                <td>{{$cours->intitule}}</td>
                <td>
                    <form action="{{route('gestionnaire.gestion.desassocier.desassocier_etudiant_cours',['eid'=>$etudiant_id,'cid'=>$cours->id])}}" method="POST">
                        @csrf
                        <button type="submit">Désassocier le cours</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection