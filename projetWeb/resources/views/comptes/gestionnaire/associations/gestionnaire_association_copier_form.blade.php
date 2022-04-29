@extends('models.index_models')

@section('title','Cours à copier')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Retour</a><hr>

@endsection

@section('content')
    <h1 class="colorful-h1">Liste des cours à copier</h1>
    <p>Description : copier tous les etudiants du cours vers une autre</p>
    <table class="table-affichage-donnee">
        <tr>
            <th>Intitule</th>
            <th>Crée le :</th>
            <th>Modifié le :</th>
            <th>Action</th>
        </tr>
        @foreach ($liste_cours as $cours)
            <tr>
                <td>{{$cours->intitule}}</td>
                <td>{{$cours->created_at}}</td>
                <td>{{$cours->updated_at}}</td>
                <td>
                    <form action="{{route('gestionnaire.association.fonction_copier',['cpid'=>$cpid,'csid'=>$cours->id])}}" method="POST">
                        @csrf
                        <button type="submit">Copier</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection