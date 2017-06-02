<!--
    Auteur: David Niembro
    Date:
    Description Affichage de la place de parc de l'utilisateur.
    -->
@extends('layouts.app')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="application/javascript" src={{asset('js/calendarLocal.js')}}></script>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills " style="padding-bottom: 25px">
                    <li class="active"><a data-toggle="pill" href="#home">Informations</a></li>
                    <li><a data-toggle="pill" href="#attente">Réservation en attente</a></li>
                    <li><a data-toggle="pill" href="#modif">Modifier</a></li>
                </ul>
                <div class="tab-content">

                    <div id="home" class="tab-pane fade in active">
                        <div class="col-md-6 " style="font-size: xx-large;padding-bottom: 25px;" >
                            <p class="customTitle">Informations pour la place N° {!! $Park->parNumber !!}</p>
                            <p class="customText">{!! $Park->parAddress !!}</p>
                            <p class="customText">{!! $Park->parPostCode !!} {!! $Park->parCity !!}</p>
                            @if($Park->parCouvert == 1)
                                <p class="customText"> Place couverte</p>
                            @else
                                <p class="customText">Place extérieur</p>
                            @endif
                            <p class="customText">{!! $Park->parPrice !!} .- / 30 min</p>
                        </div>
                        <div class="col-md-6">
                            {!! $calendar->calendar() !!}
                            {!! $calendar->script() !!}
                        </div>
                    </div>
                    <div id="attente" class="tab-pane fade">
                            @if(count($Reservations)>0)
                                @foreach($Reservations as $reservation)
                                    <div class="col-md-8 col-sm-12 ">
                                        <p class="customText">{{$reservation->user->first()->useUsername}} du {{$reservation->resStartingDate}} au {{$reservation->resFinishDate}}</p>
                                    </div>
                                <div class="col-md-2 col-sm-6 col-xs-6">
                                    {!! Form::open(['route' => ['changeStatus', $reservation->fkPark, $reservation->fkUser, 'Accepte', $reservation->resStartingDate, $reservation->resFinishDate], 'method'=>'put']) !!}
                                    {!! Form::submit('Accepter', ['class' => 'customButtonReservation','style'=>'text-align:center;']) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-6">
                                    {!! Form::open(['route' => ['changeStatus', $reservation->fkPark,$reservation->fkUser, 'Refuser',  $reservation->resStartingDate, $reservation->resFinishDate], 'method'=>'put']) !!}
                                    {!! Form::submit('Refuser', ['class' => 'customButtonReservation','style'=>'text-align:center;']) !!}
                                    {!! Form::close() !!}
                                </div>
                                @endforeach
                            @else
                                <div class="col-md-12">
                                    <p class="customText"> Il n'y a pas de demande pour l'instant.</p>
                                </div>
                            @endif

                    </div>

                    <div id="modif" class="tab-pane fade">
                        <div class="col-md-12 ">
                            <p class="customTitle">Modifier la place</p>
                        </div>
                            <div class="col-md-12" style="padding-bottom: 80px">
                                {!! Form::model($Park, ['route' => ['park.update', $Park->idPark], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
                                <div class="form-group {!! $errors->has('parNumber') ? 'has-error' : '' !!}">
                                    {!! Form::text('parNumber', null, ['class' => 'customInput', 'placeholder' => 'Place n°']) !!}
                                    {!! $errors->first('parNumber', '<small class="help-block">:message</small>') !!}
                                </div>
                                <div class="form-group {!! $errors->has('parAddress') ? 'has-error' : '' !!}">
                                    {!! Form::text('parAddress', null, ['class' => 'customInput', 'placeholder' => 'Adresse']) !!}
                                    {!! $errors->first('parAddress', '<small class="help-block">:message</small>') !!}
                                </div>
                                <div class="form-group {!! $errors->has('parPostCode') ? 'has-error' : '' !!}">
                                    {!! Form::text('parPostCode', null, ['class' => 'customInput', 'placeholder' => 'Code postal']) !!}
                                    {!! $errors->first('parPostCode', '<small class="help-block">:message</small>') !!}
                                </div>
                                <div class="form-group {!! $errors->has('parCity') ? 'has-error' : '' !!}">
                                    {!! Form::text('parCity', null, ['class' => 'customInput', 'placeholder' => 'Ville']) !!}
                                    {!! $errors->first('parCity', '<small class="help-block">:message</small>') !!}
                                </div>
                                <div class="form-group {!! $errors->has('parPrice') ? 'has-error' : '' !!}">
                                    {!! Form::text('parPrice', null, ['class' => 'customInput', 'placeholder' => 'Prix']) !!}
                                    {!! $errors->first('parPrice', '<small class="help-block">:message</small>') !!}
                                </div>
                                {!! Form::submit('Envoyer', ['class' => 'customButton pull-right']) !!}
                                {!! Form::close() !!}
                            </div>

                            <div class="col-md-12">
                                <p class="customTitle">Supprimer la place</p>
                                <p class="customText">En supprimant cette place toutes les réservations associées seront aussi supprimées</p>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['park.destroy', $Park->idPark]]) !!}
                                {!! Form::submit('Supprimer', ['class' => 'customButton','style'=>'text-align:center;' ,'onclick' => 'return confirm(\'Vraiment supprimer cette place ?\')']) !!}
                                {!! Form::close() !!}
                            </div>
                        </row>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection