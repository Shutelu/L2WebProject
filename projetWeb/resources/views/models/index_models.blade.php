{{-- Page d'accueil/Page principal --}}

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>

        {{-- section pour l'ajout de style --}}
        <link rel="stylesheet" href="/styles/index_style.css">
        {{--ajout bootstrap--}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
    </head>
    <body>
        <div class="index-container">

            {{-- Barre de navigation --}}
            <nav class="index-navigation">
                <ul id="index-navigation-ul">
                    <li><a href="{{route('pageIndex')}}">Accueil</a></li>

                    @guest
                        <li><a href="{{route('user.login_form')}}">Se connecter</a></li>
                        <li><a href="{{route('user.register_form')}}">S'inscrire</a></li>
                    @endguest

                    @auth
                        @if (Auth::user()->type == 'admin')
                            <li><a href="{{route('admin.page_gestion')}}">Gestion</a></li>
                        @endif
                        <li><a href="{{route('user.page_mon_compte')}}">Mon compte</a></li>
                        <li><a href="{{route('logout')}}">Se déconnecter</a></li>
                    @endauth
                </ul>
            </nav>

            {{-- message flash --}}
            @if (session()->has('etat'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{session()->get('etat')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Le contenu --}}
            <div class="index-content">
                @yield('content')
            </div>
        </div>
    </body>
</html>