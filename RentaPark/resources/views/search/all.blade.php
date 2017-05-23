@extends('layouts.app')

@section('content')
        @if(isset($maps))
        <div id="googleMap" style="width:100%;height:300px; position: fixed; bottom: 0" onload="myMap()"></div>
        @endif
        <div class="container">
        <script>
            @if(isset($maps))
            function myMap() {
                var myCenter = new google.maps.LatLng({{$maps['parLatitude']}},{{$maps['parLongitude']}});
                var mapCanvas = document.getElementById("googleMap");
                var mapOptions = {center: myCenter, zoom: 14};
                var map = new google.maps.Map(mapCanvas, mapOptions);
                var marker;
                @foreach($Parks as $Park)
                    marker = new google.maps.Marker({position: new google.maps.LatLng({!! $Park->parLatitude !!},{!! $Park->parLongitude !!})});
                @endforeach
                marker.setMap(map);
            }
            @endif
        </script>

        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjuZwLfnSa_iayQaFeKmQQThTnh-NP9C8&callback=myMap">
        </script>
            @if(isset($Localisation))
            <div class="col-md-12 customTitle">
                <p>Localisation: {{$Localisation}}</p>
            </div>
                @else
                <div class="col-md-12 customTitle">
                    <p>Toutes les places</p>
                </div>

            @endif
            @if(count($Parks->where('parDelete', 0)))
                @foreach($Parks->where('parDelete', 0) as $Park)
                    <div class="col-md-6 col-sm-6 text-center" style="margin-top: 80px">
                        {!! link_to_route('showOne', $Park->parAddress.' ', [$Park->idPark],['class'=>'customButton']) !!}
                    </div>
                @endforeach
            @else
                <div class="col-md-12 col-sm-12 text-center customTitle" style="margin-top: 80px">
                Il n'y a pas de place en ce moment
                </div>
            @endif
        {!! $links !!}
    </div>

@endsection