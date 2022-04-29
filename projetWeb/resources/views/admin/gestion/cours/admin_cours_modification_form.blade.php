@extends('models.index_models')

@section('title','Formulaire de modification')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('admin.cours.liste')}}">Retour</a>
@endsection

@section('content')
    <h1 class="colorful-h1">Formulaire de modification</h1>
    <p>Vous etes sur le point de modifier l'intitule du cours de : {{$cours->intitule}}</p>
    <form action="{{route('admin.cours.modifier',['cid'=>$cours->id])}}" method="POST">
        @csrf
        <label for="intitule">Intitule</label>
        <input type="text" id="intitule" name="intitule" value="{{$cours->intitule}}">
        <button type="submit">Modifier</button>
    </form>
@endsection