<!--
    Auteur: David Niembro
    Date:
    Description Affichage de toutes les places de parc
    -->
@extends('layouts.app')

@section('content')
    @if(isset($maps))
        <div id="googleMap" style="width:100%;height:300px; position: fixed; bottom: 0" onload="myMap()"></div>
    @endif
    <div class="container">
        <script>
            {{-- ? il y a un maps à afficher--}}
            @if(isset($maps))
            function myMap() {
                var myCenter = new google.maps.LatLng({{$maps['parLatitude']}},{{$maps['parLongitude']}});
                var mapCanvas = document.getElementById("googleMap");
                var mapOptions = {center: myCenter, zoom: 14};
                var map = new google.maps.Map(mapCanvas, mapOptions);
                var marker;
                marker = new google.maps.Marker({position: new google.maps.LatLng({!! $maps['parLatitude']!!},{!!$maps['parLongitude']!!})});
                marker.setMap(map);
            }
            @endif
        </script>

        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjuZwLfnSa_iayQaFeKmQQThTnh-NP9C8&callback=myMap">
        </script>

        {{--Affichage de la localisation--}}
        @if(isset($Localisation))
            <div class="col-md-12 customTitle">
                <p>Localisation: {{$Localisation}}</p>
            </div>
        @else
            <div class="col-md-12 customTitle">
                <p>Toutes les places</p>
            </div>

        @endif

        {{--? il y a des places--}}
        @if(count($Parks->where('parDelete', 0)))

            {{--affiche les places--}}
            @foreach($Parks->where('parDelete', 0) as $Park)
                @if(isset($maps))
                    @if($Park->parLatitude-$maps['parLatitude']< 0.01 || $Park->parLatitude-$maps['parLatitude']< -0.01 && $Park->parLongitude-$maps['parLongitude']< 0.01 || $Park->parLongitude-$maps['parLongitude']< -0.01)
                        <div class="col-md-6 col-sm-6 text-center" style="margin-top: 80px">
                            {!! link_to_route('showOne', $Park->parAddress.' ', [$Park->idPark],['class'=>'customButton']) !!}
                        </div>
                    @endif
                @else
                    <div class="col-md-6 col-sm-6 text-center" style="margin-top: 80px">
                        {!! link_to_route('showOne', $Park->parAddress.' ', [$Park->idPark],['class'=>'customButton']) !!}
                    </div>
                @endif
            @endforeach
        @else
            <div class="col-md-12 col-sm-12 text-center customTitle" style="margin-top: 80px">
                Il n'y a pas de place en ce moment
            </div>
        @endif
        {!! $links !!}
    </div>

@endsection