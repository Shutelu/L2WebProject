@extends('models.index_models')

@section('title','Liste des cours qui vous sont associés')

@section('content')
    <h1>Liste des cours associés</h1>
    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Action</th>
        </tr>
        @foreach ($liste_cours as $cours)
            <tr>
                <td>{{$cours->intitule}}</td>
                <td>
                    <form action="{{route('enseignant.liste.inscrit_au_cours',['cid'=>$cours->id,'eid'=>$enseignant_id])}}" method="post">
                        @csrf
                        <button type="submit">Liste des inscrits à ce cours</button>
                    </form>
                    <form action="{{route('enseignant.liste.seances_ce_cours',['cid'=>$cours->id])}}" method="POST">
                        @csrf
                        <button>Liste des séances pour ce cours</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection