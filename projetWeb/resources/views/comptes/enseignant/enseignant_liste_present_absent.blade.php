@extends('models.index_models')

@section('title','Liste des presents/absents')

@section('outils')
    <form action="{{route('enseignant.liste.seances_ce_cours',['cid'=>$cours_id,'eid'=>$enseignant_id])}}" method="POST">
        @csrf
        <button class="a_gestion_user_retour_listes">Retour</button>
    </form>

@endsection

@section('content')
    
    <table class="table-affichage-donnee">
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Numéro</th>
            <th>Presence</th>
        </tr>
        @foreach ($liste_etudiants as $etudiant)
            <tr>
                <td>{{$etudiant->nom}}</td>
                <td>{{$etudiant->prenom}}</td>
                <td>{{$etudiant->noet}}</td>

                @php
                    $bool = false;
                @endphp
                @foreach ($liste_presents as $present)
                    @if ($present->id == $etudiant->id)
                        <td>present</td>
                        @php
                            $bool = true;
                        @endphp
                        @break
                    @else  
                        @continue
                    @endif
                @endforeach
                @php
                    if(!$bool){
                        echo "<td>absent</td>";
                    } 
                    $bool = false;
                @endphp
            </tr>
        @endforeach
    </table>
@endsection