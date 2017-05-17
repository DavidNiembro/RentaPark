@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if(count($users->park) == 0 )!!}
                <div class="col-md-6 text-center">
                    <a href="{{ route('park.create') }}">Ajouter une place</a>
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
                    <div class="col-md-6 text-center">
                        {!! link_to_route('park.show', 'Place N° '.$Park->parNumber, [$Park->idPark]) !!}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection