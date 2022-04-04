@extends('models.index_models')

@section('title','Page principal')

@section('content')
    
    <p>Vous êtes sur la page d'accueil !</p>
    
    {{-- Affichage pour les comptes non authentifies --}}
    @guest
        <p>pas encore auth</p>
    @endguest

    {{-- Affichage pour les comptes authentifies --}}
    @auth
        <p>auth</p>
    @endauth


@endsection