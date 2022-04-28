@extends('models.index_models')

@section('title','Liste des cours qui vous sont associés')

@section('content')

    <h1>Liste des cours associés</h1>

    @php
        $total = 0
    @endphp

    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Action</th>
            <th>Totaux de présence du cours</th>
        </tr>
        @foreach ($liste_cours as $cours)
            <tr>
                <td>{{$cours->intitule}}</td>
                <td>
                    <form action="{{route('enseignant.liste.inscrit_au_cours',['cid'=>$cours->id,'eid'=>$enseignant_id])}}" method="post">
                        @csrf
                        <button type="submit">Liste des inscrits à ce cours</button>
                    </form>
                    <form action="{{route('enseignant.liste.seances_ce_cours',['cid'=>$cours->id,'eid'=>$enseignant_id])}}" method="POST">
                        @csrf
                        <button>Liste des séances pour ce cours</button>
                    </form>
                </td>
                @php    
                        //on va chercher d'abord tout les etudiants du cours
                        $liste_etudiants_pour_ce_cours = $cours->etudiants;
                        foreach($liste_etudiants_pour_ce_cours as $etudiant){
                            //puis tout les seances du cours
                            foreach($cours->seances as $seance){

                                $liste_present = $seance->etudiants;
                                //on comparer comme on a fait dans la liste present absent
                                foreach($liste_present as $present){

                                    if($present->id == $etudiant->id){
                                        $total += 1;
                                    }
                                }
                            }
                        }

                        //marche mais avec juste un petit prob de +1 pour math introuvable | quantite 11 au lieu de 10
                        // foreach($cours->seances as $seance){
                        //     $total += $seance->etudiants()->count();
                        // }

                @endphp
                <td>{{$total}}</td>
            </tr>
            @php
                $total = 0
            @endphp
        @endforeach
    </table>
@endsection