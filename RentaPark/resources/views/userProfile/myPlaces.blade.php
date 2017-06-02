<!--
    Auteur: David Niembro
    Date:
    Description Affichage de toutes les places de parc de l'utilisateur ou du lien vers le formulaire
    -->
@extends('layouts.app')

@section('content')
    <div class="container">

        @if(session()->has('ok'))
            <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            </div>
        @endif

        <div class="col-md-12 text-center" >
            <p class="customTitle">Mes places</p>
        </div>

        {{--? nombre de place de l'utilisateur--}}
        @if(count($users->park->where('parDelete', 0)) == 0 )
            <div class="col-md-6 col-md-offset-3" style="margin-top: 80px">
                <a href="{{ route('park.create') }}" style="text-decoration: none" >
                    <div class="jumbotron text-center" style="border:2px solid red; background-color: transparent;color: red;font-size: 30px;">
                        Ajouter une place
                    </div>
                </a>
            </div>
        @elseif(count($users->park->where('parDelete', 0)) == 1 )
            @foreach($users->park->where('parDelete', 0) as $Park)
                <div class="col-md-6 text-center" style="margin-top: 80px">
                    {!! link_to_route('park.show', 'Place N° '.$Park->parNumber, [$Park->idPark],['class'=>'customButton']) !!}
                </div>
            @endforeach
            <div class="col-md-6 text-center" style="margin-top: 80px">
                <a href="{{ route('park.create') }}" class="customButton">Ajouter une place</a>
            </div>
        @elseif(count($users->park->where('parDelete', 0)) == 2)
            @foreach($users->park->where('parDelete', 0) as $Park)
                <div class="col-md-6 text-center" style="margin-top: 80px">
                    {!! link_to_route('park.show', 'Place N° '.$Park->parNumber, [$Park->idPark],['class'=>'customButton']) !!}
                </div>
            @endforeach
        @endif
    </div>
    <div class="container">
        <div class="col-md-12 text-center">
            <p class="customTitle" style="margin-top: 100px"> Historique de mes places</p>
        </div>

        {{--? nombre de place de l'utilisateur--}}
        @if(count($users->park->where('parDelete', 1)) == 0 )
            <div class="col-md-6 col-md-offset-3" style="margin-top: 80px">
                <p> Vous n'avaz pas de places supprimées</p>
            </div>
        @elseif(count($users->park->where('parDelete', 1)) == 1 )
            @foreach($users->park->where('parDelete', 1) as $Park)
                <div class="col-md-6 text-center" style="margin-top: 80px">
                    {!! link_to_route('park.show', 'Place N° '.$Park->parNumber, [$Park->idPark],['class'=>'customButton']) !!}
                </div>
            @endforeach
        @endif

    </div>
@endsection