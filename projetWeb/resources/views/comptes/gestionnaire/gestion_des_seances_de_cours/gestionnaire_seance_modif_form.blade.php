@extends('models.index_models')

@section('title','Formulaire de modification')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('gestionnaire.gestion.gestion_seances')}}">Retour</a>
@endsection

@section('content')
    <h1>Formulaire de modification</h1>
    
    <form action="{{route('gestionnaire.seance.modifier',['sid'=>$seance->id])}}" method="POST">
        @csrf
        <label for="debut">Date début</label>
        <input type="datetime-local" id="debut" name="debut" value="{{$seance->date_debut}}"><br>
        <label for="fin">Date fin</label>
        <input type="datetime-local" id="fin" name="fin" value="{{$seance->date_fin}}"><br>

        <button type="submit">Modifier</button>
    </form>
@endsection