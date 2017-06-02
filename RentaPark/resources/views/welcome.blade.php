@extends('layouts.app')

@section('content')

        <div class="container">
            <div class="row">
                <div class="col-md-8  col-md-offset-2">
                    <div style="width: 60%;margin-left: auto;margin-right: auto">
                        {!! Form::open(['route' => 'search']) !!}
                        <p class="customTitle">Avec RentaPark, cherchez, trouvez et louez les places de particulier en un clic</p>
                                    <input type='text' style='margin-bottom: 50px;' class="customInput" name="ville" placeholder="Ville"/>
                        {!! Form::submit('Chercher', ['class' => 'customButton']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
</html>

@endsection