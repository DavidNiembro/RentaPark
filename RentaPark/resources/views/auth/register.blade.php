@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 customTitle">
            Register
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                    @if (session('confirmation-success'))
                        <div class="alert alert-success">
                            {{ session('confirmation-success') }}
                        </div>
                    @else
                        <form role="form" method="POST" action="{{ url('/register') }}">
                            {{ csrf_field() }}
                            <div>Données personnelles</div>
                            <div class="form-group{{ $errors->has('useName') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input id="useName" type="text" class="customInput" name="useName" value="{{ old('useName') }}" required autofocus placeholder="Nom">

                                    @if ($errors->has('useName'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('useName') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('useFirstName') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input id="useFirstName" type="text" class="customInput" name="useFirstName" value="{{ old('useFirstName') }}" required autofocus placeholder="Prénom">

                                    @if ($errors->has('useFirstName'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('useFirstName') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('useCity') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input id="useCity" type="text" class="customInput" name="useCity" value="{{ old('useCity') }}" required autofocus placeholder="Ville">

                                    @if ($errors->has('useCity'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('useCity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('useLand') ? ' has-error' : '' }}">


                                <div class="col-md-12">
                                    <input id="useLand" type="text" class="customInput" name="useLand" value="{{ old('useLand') }}" required autofocus placeholder="Pays">

                                    @if ($errors->has('useLand'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('useLand') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('usePictureProfil') ? ' has-error' : '' }}">

                                <div class="col-md-12">
                                    <input id="usePictureProfil" type="text" class="customInput" name="usePictureProfil" value="{{ old('usePictureProfil') }}" required autofocus placeholder="Image de profil A changer">

                                    @if ($errors->has('usePictureProfil'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('usePictureProfil') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>Création du compte</div>
                            <div class="form-group{{ $errors->has('useUsername') ? ' has-error' : '' }}">


                                <div class="col-md-12">
                                    <input id="useUsername" type="text" class="customInput" name="useUsername" value="{{ old('useUsername') }}" required autofocus placeholder="Nom d'utilisateur">

                                    @if ($errors->has('useUsername'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('useUsername') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">


                                <div class="col-md-12">
                                    <input id="email" type="email" class="customInput" name="email" value="{{ old('email') }}" required placeholder="Email">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">


                                <div class="col-md-12">
                                    <input id="password" type="password" class="customInput" name="password" required placeholder="Mot de passe">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="customInput" name="password_confirmation" required placeholder="Confirmer le mot de passe">
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-6">
                                    <button type="submit" class="btn  btn-danger">
                                        S'enregister
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
@endsection
