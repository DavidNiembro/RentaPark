<!--
    Auteur: David Niembro
    Date:
    Description Formulaire de la page d'édition
    -->
@extends('layouts.app')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>


@section('content')
    <div class="container">
        <div class="col-md-12">
            <p class="customTitle"> Modifier l'horaire de la réservation</p>
        </div>
        @foreach($Reservations as $reservation)
            {!! Form::model($reservation, ['route' => ['reservationEditStore', $reservation->fkPark, $reservation->fkUser, $reservation->resStartingDate, $reservation->resFinishDate], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
            <div class='col-md-5'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker6'>
                        <input type='datetime' class="customInput" name="Start" value="{{$reservation->resStartingDate}}" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-md-5'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker7'>
                        <input type='datetime' class="customInput" name="End" value="{{$reservation->resFinishDate}}" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            {!! Form::submit('Envoyer', ['class' => 'customButton pull-right']) !!}
            {!! Form::close() !!}
        @endforeach
    </div>
@endsection