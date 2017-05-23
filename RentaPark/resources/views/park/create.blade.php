@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8 customTitle">
                Ajoutez une nouvelle place
        </div>
        <div class="col-sm-offset-2 col-sm-8">
            {!! Form::open(['route' => 'park.store']) !!}
            <div class="form-group {!! $errors->has('parNumber') ? 'has-error' : '' !!}">
                {!! Form::text('parNumber', null, ['class' => 'customInput', 'placeholder' => 'Numéro de la place']) !!}
                {!! $errors->first('parNumber', '<small class="help-block">:message</small>') !!}
            </div>
            <div class="form-group {!! $errors->has('parAddress') ? 'has-error' : '' !!}">
                {!! Form::text('parAddress', null, ['class' => 'customInput', 'placeholder' => 'Adresse de la place']) !!}
                {!! $errors->first('parAddress', '<small class="help-block">:message</small>') !!}
            </div>
            <div class="form-group {!! $errors->has('parPostCode') ? 'has-error' : '' !!}">
                {!! Form::text('parPostCode', null, ['class' => 'customInput', 'placeholder' => 'NPA']) !!}
                {!! $errors->first('parPostCode', '<small class="help-block">:message</small>') !!}
            </div>
            <div class="form-group {!! $errors->has('parCity') ? 'has-error' : '' !!}">
                {!! Form::text('parCity', null, ['class' => 'customInput', 'placeholder' => 'Ville']) !!}
                {!! $errors->first('parCity', '<small class="help-block">:message</small>') !!}
            </div>
            <div class="form-group {!! $errors->has('parPrice') ? 'has-error' : '' !!}">
                {!! Form::text('parPrice', null, ['class' => 'customInput', 'placeholder' => 'Prix par 1/2 Heure']) !!}
                {!! $errors->first('parPrice', '<small class="help-block">:message</small>') !!}
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('parCouvert', 1, null) !!} Place couverte
                    </label>
                </div>
            </div>
            <a href="javascript:history.back()" class="btn btn-default">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
            </a>
            {!! Form::submit('Ajouter', ['class' => 'btn btn-danger pull-right']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection