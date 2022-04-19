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
                <td>Action</td>
            </tr>
        @endforeach
    </table>
@endsection