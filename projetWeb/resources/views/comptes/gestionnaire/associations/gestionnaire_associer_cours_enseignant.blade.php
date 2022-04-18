@extends('models.index_models')

@section('title','Association de l\'enseignant à cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_enseignants')}}">Retour</a><hr>

@endsection

@section('content')
    <h1>Liste des cours</h1>

    <p>Description : Voici la liste des cours que vous pouvez associer à l'enseignant</p>

    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Action</th>
        </tr>
        @foreach ($liste_cours as $cours)
            <tr>
                <td>{{$cours->intitule}}</td>
                <td>
                    <form action="{{route('gestionnaire.gestion.associer.associer_enseignant_cours',['eid'=>$enseignant_id,'cid'=>$cours->id])}}" method="POST">
                        @csrf
                        <button>Associer à ce cours</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{$liste_cours->links()}}
@endsection