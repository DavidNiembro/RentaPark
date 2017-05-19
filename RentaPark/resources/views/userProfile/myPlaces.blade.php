@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if(count($users->park) == 0 )
                <div class="col-md-6 col-md-offset-3">
                    <a href="{{ route('park.create') }}" style="text-decoration: none">
                        <div class="jumbotron text-center" style="border:2px solid red; background-color: transparent;color: red;font-size: 30px;">
                            Ajouter une place
                        </div>
                    </a>
                </div>
            @elseif(count($users->park) == 1 )
                @foreach($users->park as $Park)
                    <div class="col-md-6 text-center">
                        {!! link_to_route('park.show', 'Place N° '.$Park->parNumber, [$Park->idPark]) !!}
                    </div>
                @endforeach
                <div class="col-md-6 text-center">
                    <a href="{{ route('park.create') }}">Ajouter une place</a>
                </div>
            @elseif(count($users->park) == 2)
                @foreach($users->park as $Park)
                    <div class="col-md-6 text-center" style="margin-top: 80px">
                        {!! link_to_route('park.show', 'Place N° '.$Park->parNumber, [$Park->idPark],['class'=>'customButton']) !!}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection