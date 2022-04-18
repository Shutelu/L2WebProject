@extends('models.index_models')

@section('tilte','Désassociation enseignant cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_enseignants')}}">Retour</a><hr>

@endsection

@section('content')
    <h1>Désassociation enseignant cours</h1>

    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Action</th>
        </tr>

        @foreach ($liste_cours as $cours)
            <tr>
                <td>{{$cours->intitule}}</td>
                <td>
                    <form action="{{route('gestionnaire.gestion.desassocier.desassocier_enseignant_cours',['eid'=>$enseignant_id,'cid'=>$cours->id])}}" method="POST">
                        @csrf
                        <button type="submit">Désassocier le cours</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection