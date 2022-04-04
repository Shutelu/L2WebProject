{{--Page admin--}}

@extends('models.index_models')

@section('title','Page administrateur')

@section('content')
    @auth
    <p>Vous êtes authentifié Administrateur</p>

    @endauth  
@endsection