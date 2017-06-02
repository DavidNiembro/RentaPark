<!--
    Auteur: David Niembro
    Date:
    Description page d'envoi de lien pour la récupération de mot de passe
    -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 customTitle">
                Obtenir un nouveau mot de passe
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 customTitle">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endifs
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 customTitle">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="email" type="email" class="customInput" name="email" value="{{ old('email') }}" required placeholder="Email">
                                @if($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-danger">
                                    Envoyer un lien de récuperation de mot de passe
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
