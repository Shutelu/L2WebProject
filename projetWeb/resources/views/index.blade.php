@extends('models.index_models')

@section('title','Page principal')

@section('content')
    
    <h1 class="colorful-h1">Vous êtes sur la page d'accueil !</h1>
    
    {{-- Affichage pour les comptes non authentifies --}}
    @guest
        <p>pas encore auth</p>
    @endguest

    {{-- Affichage pour les comptes authentifies --}}
    @auth
        <p>auth</p>
    @endauth


@endsection