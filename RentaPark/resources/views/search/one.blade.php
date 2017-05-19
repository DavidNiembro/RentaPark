@extends('layouts.app')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="application/javascript" src={{asset('js/calendarLocal.js')}}></script>

@section('content')
    <body>
    <div class="container">
        <div class="row">
            <div class="col-md-4" style="font-size: xx-large">
                <p>Place n° {!! $park->parNumber !!}</p>
                <p>{!! $park->parAddress !!}</p>
                <p>{!! $park->parPostCode !!} {!! $park->ParCity !!}</p>
                <p>@if($park->parCouvert == 1)
                        Place couverte
                    @else
                        Place extérieur
                    @endif</p>
                <p>{!! $park->parPrice !!}.- / 30 min</p>

            </div>
            <div class="col-md-8">
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
            </div>
        </div>

        @if(Auth::guest())
            <div class="row">
                <div class='col-md-12 text-center'>
                    Connecter-vous pour reserver une place rapidement.
                </div>
            </div>
        @else
        <div class="row">

            <div class='col-md-12 text-center'>
            Réserver la place
            </div>
            {!! Form::open(['route' => 'reservation.store']) !!}
            <div class='col-md-5'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker6'>
                        <input type='text' class="form-control" name="Start" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class='col-md-5'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker7'>
                        <input type='text' class="form-control" name="End" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <input type="hidden" name="PlaceID" value="{{$park->idPark}}">
            {!! Form::submit('RESERVER', ['class' => 'btn btn-danger pull-right']) !!}
            {!! Form::close() !!}
        </div>
        @endif
        <div id="googleMap" style="width:100%;height:500px; position: fixed; bottom: 0" onload="myMap()"></div>

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
    </div>


@endsection
