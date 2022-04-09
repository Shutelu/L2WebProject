@extends('models.index_models')

@section('title','Liste des cours pour l\'administrateur')

@section('outils')
    <a class="a_gestion_user_retour_listes" href="{{route('admin.page_gestion')}}">Page de gestion</a>
@endsection

@section('content')
    <h1>Liste de tout les cours</h1>
    <p>Description : Vous etes sur la liste de tout les cours </p>
    <br>
    <form action="{{route('admin.gestion.cours_create')}}" method="POST">
        @csrf
        <label for="intitule">Intitulé</label>
        <input type="text" id="intitule" name="intitule">
        <button type="submit">Crée le cours</button>
    </form>
    {{-- <span id="admin_gestion_user_create"><a href="{{route('admin.gestion.cours_create_form')}}">Crée un cours</a></span> --}}
    <br>
    <table class="table-affichage-donnee">
        <tr>
            <th>Intitulé</th>
            <th>Crée le</th>
            <th>Modifié le</th>
            <th>Actions</th>
        </tr>
        @foreach ($cours_liste as $cl)
            <tr>
                <td>{{$cl->intitule}}</td>
                <td>{{$cl->created_at}}</td>
                <td>{{$cl->updated_at}}</td>
                <td>modif/supp</td>
            </tr>
        @endforeach
    </table>
@endsection