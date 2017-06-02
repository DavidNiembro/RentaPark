<!--
    Auteur: David Niembro
    Date:
    Description Affichage de la place
    -->
@extends('layouts.app')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="application/javascript" src={{asset('js/calendarLocal.js')}}></script>

@section('content')
    <body>
    <div class="container" style="padding-bottom: 50px">
        <div class="row">
            {{--Message d'erreur--}}
            <div class="col-sm-offset-4 col-sm-4">
                @if(session()->has('ok'))
                    <div class="alert alert-danger alert-dismissible">{!! session('ok') !!}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="font-size: xx-large">
                <p class="customTitle">Place n° {!! $park->parNumber !!}</p>
                <p class="customText">{!! $park->parAddress !!}</p>
                <p class="customText">{!! $park->parPostCode !!} {!! $park->parCity !!}</p>
                <p class="customText">@if($park->parCouvert == 1)
                        Place couverte
                    @else
                        Place extérieur
                    @endif</p>
                <p class="customText">{!! $park->parPrice !!}.- / 30 min</p>

            </div>
            <div class="col-md-6">

                {{--Génération du calendrier et affichage--}}
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
            </div>
        </div>


        {{--? Utilisateur connecté--}}
        @if(Auth::guest())
            <div class="row">
                <div class='col-md-12 text-center customTitle'>
                    Connecter-vous pour reserver une place rapidement.
                </div>
            </div>
        @else
            <div class="row" style="padding-top: 50px">
                <div class='col-md-12 text-center customTitle'>
                    Réserver la place
                </div>
                {!! Form::open(['route' => 'reservation.store']) !!}
                <div class='col-md-5'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker6'>
                            <input type='datetime' class="customInput" name="Start" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>
                </div>

                <div class='col-md-5'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker7'>
                            <input type='datetime' class="customInput" name="End" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <input type="hidden" name="PlaceID" value="{{$park->idPark}}">
                    {!! Form::submit('RESERVER', ['class' => 'customButton']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @endif
    </div>

    {{--Affichage du maps--}}
        <div id="googleMap" style="width:100%;height:500px; position: fixed; bottom: 0;" onload="myMap()"></div>

        <script>
            function myMap() {
                var myCenter = new google.maps.LatLng({!! $park->parLatitude !!},{!! $park->parLongitude !!});
                var mapCanvas = document.getElementById("googleMap");
                var mapOptions = {center: myCenter, zoom: 12};
                var map = new google.maps.Map(mapCanvas, mapOptions);
                var marker = new google.maps.Marker({position:myCenter});
                marker.setMap(map);
            }
        </script>

        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjuZwLfnSa_iayQaFeKmQQThTnh-NP9C8&callback=myMap">
        </script>
@endsection
