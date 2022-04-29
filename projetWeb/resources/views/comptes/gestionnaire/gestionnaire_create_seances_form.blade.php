@extends('models.index_models')

@section('title','Formulaire de creation de seances de cours')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_cours')}}">Retour</a><hr>
    <p>* : champ obligatoire</p>
@endsection

@section('content')
    <h1 class="colorful-h1">Formulaire de creation de seances de cours</h1>

    <p>Description : Vous vous apprêtez à crée une séance pour le cours de : {{$cours->intitule}}</p>
    <form action="{{route('gestionnaire.gestion.create_seances',['id'=>$cours->id])}}" method="POST">
        @csrf
        <label for="ddebut">Date et heure de debut du cours* : </label>
        <input type="datetime-local" id="ddebut" name="ddebut" value="{{old('ddebut')}}">
        {{-- <label for="ddebutHeure">Heure</label>
        <input type="number" id="ddebutHeure" name="ddebutHeure" max="23" min="00" value="{{old('ddebutHeure')}}">
        <label for="ddebutMin">Minute</label>
        <input type="number" id="ddebutMin" name="ddebutMin" max="59" min="00" value="{{old('ddebutMin')}}"> --}}
        <br>
        <label for="dfin">Date et heure de fin du cours* : </label>
        <input type="datetime-local" id="dfin" name="dfin" value="{{old('dfin')}}">
        {{-- <label for="dfinHeure">Heure</label>
        <input type="number" id="dfinHeure" name="dfinHeure" max="23" min="00" value="{{old('dfinHeure')}}">
        <label for="dfinMin">Minute</label>
        <input type="number" id="dfinMin" name="dfinMin" max="59" min="00" value="{{old('dfinMin')}}"> --}}
        <br>
        <button type="submit">Cree la seance</button>
    </form>
@endsection