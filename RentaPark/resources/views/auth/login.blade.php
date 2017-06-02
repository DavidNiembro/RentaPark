<!--
    Auteur: David Niembro
    Date:
    Description Page de login
    -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 customTitle">
                Login
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (session('confirmation-success'))
                    <div class="alert alert-success">
                        {{ session('confirmation-success') }}
                    </div>
                @endif
                @if (session('confirmation-danger'))
                    <div class="alert alert-danger">
                        {!! session('confirmation-danger') !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
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
                        <div class="col-md-12 ">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Se souvenir de moi
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-danger">
                                Login
                            </button>
                            <a class="btn btn-default" href="{{ url('/password/reset') }}">
                                Mot de passe oublié?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
