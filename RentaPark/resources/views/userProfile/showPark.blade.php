@extends('layouts.app')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="application/javascript" src={{asset('js/calendarLocal.js')}}></script>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 " style="font-size: xx-large">
            Place N° {!! $Park->parNumber !!}
            </div>
            <div class="col-md-8 col-lg-offset-2">
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
            </div>
        </div>
        <div class="row">
            <div class="container">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href="#home">En Attente</a></li>
                    <li><a data-toggle="pill" href="#menu1">Modifier</a></li>

                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        @if(count($Reservations)>0)
                            @foreach($Reservations as $reservation)
                                {{$reservation->user->first()->useUsername}} du {{$reservation->resStartingDate}} au {{$reservation->resFinishDate}}
                                {!! Form::open(['route' => ['changeStatus', $reservation->fkPark, 'Accepte', $reservation->resStartingDate, $reservation->resFinishDate], 'method'=>'put']) !!}
                                {!! Form::submit('Accepter', ['class' => 'btn btn-primary pull-right']) !!}
                                {!! Form::close() !!}
                                {!! Form::open(['route' => ['changeStatus', $reservation->fkPark, 'Refuser', $reservation->resStartingDate, $reservation->resFinishDate], 'method'=>'put']) !!}
                                {!! Form::submit('Refuser', ['class' => 'btn btn-primary pull-right']) !!}
                                {!! Form::close() !!}

                                <br>
                            @endforeach
                        @else
                            Il n'y a pas de demande pour l'instant.
                        @endif
                    </div>

                    <div id="menu1" class="tab-pane fade">
                        {!! Form::model($Park, ['route' => ['park.update', $Park->idPark], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
                        <div class="form-group {!! $errors->has('parNumber') ? 'has-error' : '' !!}">
                            {!! Form::text('parNumber', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                            {!! $errors->first('parNumber', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('parAddress') ? 'has-error' : '' !!}">
                            {!! Form::text('parAddress', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                            {!! $errors->first('parAddress', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('parPostCode') ? 'has-error' : '' !!}">
                            {!! Form::text('parPostCode', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                            {!! $errors->first('parPostCode', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('parCity') ? 'has-error' : '' !!}">
                            {!! Form::text('parCity', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                            {!! $errors->first('parCity', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('parPrice') ? 'has-error' : '' !!}">
                            {!! Form::text('parPrice', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                            {!! $errors->first('parPrice', '<small class="help-block">:message</small>') !!}
                        </div>
                        {!! Form::submit('Envoyer', ['class' => 'btn btn-primary pull-right']) !!}
                        {!! Form::close() !!}
                        {!! Form::open(['method' => 'DELETE', 'route' => ['park.destroy', $Park->idPark]]) !!}
                        {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Vraiment supprimer cette place ?\')']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
<script>

</script>
@endsection