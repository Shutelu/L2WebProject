@extends('models.index_models')

@section('title','Desassociation multiple')

@section('content')
    <h1 class="colorful-h1">Desassociation multiple</h1>

    <form action="{{route('gestionnaire.desassociation.desa_multi',['cid'=>$cid])}}" method="POST">
        @csrf
        
        <table class="table-affichage-donnee">
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Numéro</th>
            </tr>
            @foreach ($liste_etudiants as $etudiant)
                <tr>
                    <td>{{$etudiant->nom}}</td>
                    <td>{{$etudiant->prenom}}</td>
                    <td>{{$etudiant->noet}}</td>
                    <td>
                        <input type="checkbox" name="desassociation[]" value="{{$etudiant->id}}"> Desassocier
                    </td>
                </tr>
            @endforeach
        </table>

        <button type="submit">Envoyé</button>
    </form>
@endsection