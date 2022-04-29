@extends('models.index_models')

@section('title','Association multiple')

@section('content')
    <h1 class="colorful-h1">Association multiple</h1>
    <form action="{{route('gestionnaire.association.asso_mult_fonction',['cid'=>$cid])}}" method="POST">
        @csrf

        <table class="table-affichage-donnee">
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Numéro</th>
                <th>Action</th>
            </tr>
            @foreach ($liste_etudiants as $etudiant)
                <tr>
                    <td>{{$etudiant->nom}}</td>
                    <td>{{$etudiant->prenom}}</td>
                    <td>{{$etudiant->noet}}</td>
                    <td>
                        <input type="checkbox" name="association[]" value="{{$etudiant->noet}}"> Associer
                    </td>
                </tr>
            @endforeach
        </table>

        <button type="submit">Envoyé</button>
    </form>
@endsection