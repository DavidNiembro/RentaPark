<!--
    Auteur: David Niembro
    Date:
    Description Affichage du tableau de board
    -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12" style="text-align: center">
        <img src="{{asset('imagesProfil/'. $user->usePictureProfil)}}" height="200" style="border-radius: 50%;border: 1px solid red">
       <p class="customTitle">Bienvenue {{$user->useFirstName}}</p>
        </div>
        <div class="col-md-5 col-md-offset-1">
            <a href="{{ route('MyPlaces') }}" style="text-decoration: none">
                <div class="jumbotron text-center" style="border:2px solid red; background-color: transparent;color: red;font-size: 30px;">
                    Mes places
                </div>
            </a>
        </div>
        <div class="col-md-5">
            <a href="{{ route('MyReservations') }}" style="text-decoration: none">
                <div class="jumbotron text-center" style="border:2px solid red; background-color: transparent;color: red;font-size: 30px; ">
                    Mes réservations
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
