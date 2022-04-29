@extends('models.index_models')

@section('title','Pointage multiple')

@section('outils')
    <form action="{{route('enseignant.liste.seances_ce_cours',['cid'=>$cours->id,'eid'=>$enseignant_id])}}" method="POST">
        @csrf
        <button class="a_gestion_user_retour_listes">Retour</button>
    </form>
@endsection

@section('content')
    <h1 class="colorful-h1">Pointage multiple</h1>

    
    <form action="{{route('enseignant.pointer.pointage_multiple',['cid'=>$cours->id,'sid'=>$seance_id,'eid'=>$enseignant_id])}}" method="POST">
        @csrf
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
                            <input type="checkbox" name="pointage[]" value="{{$etudiant->noet}}"> Pointer
                        </td>
                    </tr>
                @endforeach
        </table>
        <button type="submit">Confirmer</button>
    </form>
@endsection