<!--
    Auteur: David Niembro
    Date:
    Description Affichage des réservations de l'utilisateur
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
                    <li class="active"><a data-toggle="pill" href="#home">Mes réservations</a></li>
                    <li><a data-toggle="pill" href="#attente">Modification</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="col-md-12">
                        <p class="customTitle">Mes réservations</p>
                        {!! $calendar->calendar() !!}{!! $calendar->script() !!}
                    </div>
                </div>

                <div id="attente" class="tab-pane fade">
                    <div class="col-md-12">
                        <p class="customTitle">Modification de mes réservations</p>
                    </div>
                    <div class="col-md-12">
                        @if(count($Reservations)>0)
                            @foreach($Reservations as $reservation)
                                <div class="col-md-8 col-sm-12 ">
                                    <p class="customText">Du {{$reservation->resStartingDate}} au {{$reservation->resFinishDate}}</p>
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-6">
                                    {!! Form::open(['route' => ['reservationEdit', 'fkPark' => $reservation->fkPark, 'fkUser'=>$reservation->fkUser, 'start'=>$reservation->resStartingDate,'end'=>$reservation->resFinishDate], 'method'=>'post']) !!}
                                    {!! Form::submit('Modifer', ['class' => 'customButtonReservation','style'=>'text-align:center;']) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-6">
                                    {!! Form::open(['route' => ['reservationDestroy', 'fkPark' => $reservation->fkPark, 'fkUser'=>$reservation->fkUser, 'start'=>$reservation->resStartingDate, 'end'=>$reservation->resFinishDate], 'method'=>'post']) !!}
                                    {!! Form::submit('Supprimer', ['class' => 'customButtonReservation','style'=>'text-align:center;','onclick' => 'return confirm(\'Vraiment supprimer cette réservation ?\')']) !!}
                                    {!! Form::close() !!}

                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <p class="customText"> Il n'y a pas de réservation.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection