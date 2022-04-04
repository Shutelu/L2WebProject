@extends('models.index_models')

@section('title','Page principal')

@section('content')
    
    {{-- Affichage pour les comptes non authentifies --}}
    @guest
        
    @endguest

    {{-- Affichage pour les comptes authentifies --}}
    @auth
        
    @endauth

    <p>Vous êtes sur la page d'accueil !</p>
    
@endsection