{{--Page admin--}}

@extends('models.index_models')

@section('title','Page administrateur')

@section('content')
    @auth
    <h1>Bonjour !</h1>
    <p>Vous êtes authentifié Administrateur</p>

    @endauth  
@endsection