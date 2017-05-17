@extends('layouts.app')

@section('content')
    <div class="col-sm-offset-4 col-sm-4">
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading">Création d'un utilisateur</div>
            <div class="panel-body">
                <div class="col-sm-12">
                    {!! Form::open(['route' => 'park.store', 'class' => 'form-horizontal panel']) !!}
                    <div class="form-group {!! $errors->has('parNumber') ? 'has-error' : '' !!}">
                        {!! Form::text('parNumber', null, ['class' => 'form-control', 'placeholder' => 'Numéro de la place']) !!}
                        {!! $errors->first('parNumber', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('parAddress') ? 'has-error' : '' !!}">
                        {!! Form::text('parAddress', null, ['class' => 'form-control', 'placeholder' => 'Adresse de la place']) !!}
                        {!! $errors->first('parAddress', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('parPostCode') ? 'has-error' : '' !!}">
                        {!! Form::text('parPostCode', null, ['class' => 'form-control', 'placeholder' => 'NPA']) !!}
                        {!! $errors->first('parPostCode', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('ParCity') ? 'has-error' : '' !!}">
                        {!! Form::text('ParCity', null, ['class' => 'form-control', 'placeholder' => 'Ville']) !!}
                        {!! $errors->first('ParCity', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('parPrice') ? 'has-error' : '' !!}">
                        {!! Form::text('parPrice', null, ['class' => 'form-control', 'placeholder' => 'Prix par 1/2 Heure']) !!}
                        {!! $errors->first('parPrice', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('parCouvert', 1, null) !!} Place couverte
                            </label>
                        </div>
                    </div>
                    {!! Form::submit('Envoyer', ['class' => 'btn btn-primary pull-right']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <a href="javascript:history.back()" class="btn btn-primary">
            <span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
        </a>
    </div>
@endsection