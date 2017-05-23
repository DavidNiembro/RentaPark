@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-4 col-sm-4">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
        </div>
        <div class="row">
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
    </div>
@endsection