@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('useUsername') ? ' has-error' : '' }}">
                            <label for="useUsername" class="col-md-4 control-label">Username</label>

                            <div class="col-md-6">
                                <input id="useUsername" type="text" class="form-control" name="useUsername" value="{{ old('useUsername') }}" required autofocus>

                                @if ($errors->has('useUsername'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('useUsername') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('useMail') ? ' has-error' : '' }}">
                            <label for="useMail" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="useMail" type="useMail" class="form-control" name="useMail" value="{{ old('useMail') }}" required>

                                @if ($errors->has('useMail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('useMail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('usePictureProfil') ? ' has-error' : '' }}">
                            <label for="usePictureProfil" class="col-md-4 control-label">usePictureProfil</label>

                            <div class="col-md-6">
                                <input id="usePictureProfil" type="text" class="form-control" name="usePictureProfil" value="{{ old('usePictureProfil') }}" required autofocus>

                                @if ($errors->has('usePictureProfil'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usePictureProfil') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('useName') ? ' has-error' : '' }}">
                            <label for="useName" class="col-md-4 control-label">useName</label>

                            <div class="col-md-6">
                                <input id="useName" type="text" class="form-control" name="useName" value="{{ old('useName') }}" required autofocus>

                                @if ($errors->has('useName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('useName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('useFirstName') ? ' has-error' : '' }}">
                            <label for="useFirstName" class="col-md-4 control-label">useFirstName</label>

                            <div class="col-md-6">
                                <input id="useFirstName" type="text" class="form-control" name="useFirstName" value="{{ old('useFirstName') }}" required autofocus>

                                @if ($errors->has('useFirstName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('useFirstName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('useCity') ? ' has-error' : '' }}">
                            <label for="useCity" class="col-md-4 control-label">useCity</label>

                            <div class="col-md-6">
                                <input id="useCity" type="text" class="form-control" name="useCity" value="{{ old('useCity') }}" required autofocus>

                                @if ($errors->has('useCity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('useCity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('useLand') ? ' has-error' : '' }}">
                            <label for="useLand" class="col-md-4 control-label">useLand</label>

                            <div class="col-md-6">
                                <input id="useLand" type="text" class="form-control" name="useLand" value="{{ old('useLand') }}" required autofocus>

                                @if ($errors->has('useLand'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('useLand') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection