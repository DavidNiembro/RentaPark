@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('MyPlaces') }}">Mes places</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('MyReservations') }}">Mes réservations</a>
        </div>
    </div>
</div>
@endsection
