@extends('layouts.app')

@section('content')

        <div id="googleMap" style="width:100%;height:300px; position: fixed; bottom: 0" onload="myMap()"></div>
        <div class="container">
        <script>
            function myMap() {
                var myCenter = new google.maps.LatLng('46.5333','6.6667');
                var mapCanvas = document.getElementById("googleMap");
                var mapOptions = {center: myCenter, zoom: 12};
                var map = new google.maps.Map(mapCanvas, mapOptions);
                var marker;
                @foreach($Parks as $Park)
                    marker = new google.maps.Marker({position: new google.maps.LatLng({!! $Park->parLatitude !!},{!! $Park->parLongitude !!})});
                @endforeach
                marker.setMap(map);
            }
        </script>

        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjuZwLfnSa_iayQaFeKmQQThTnh-NP9C8&callback=myMap">
        </script>
            <div class="col-md-12 customTitle">
                <p>Localisation: Lausanne</p>
            </div>
    @foreach($Parks as $Park)
        <div class="col-md-4 col-sm-6 text-center" style="margin-top: 80px">
            {!! link_to_route('showOne', 'Place N° '.$Park->parNumber, [$Park->idPark],['class'=>'customButton']) !!}
        </div>
    @endforeach
        {!! $links !!}
    </div>

@endsection