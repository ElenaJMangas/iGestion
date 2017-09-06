@extends('layouts.login')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <b>Login</b>
        </div>
        <div class="login-box-body">

        @if(Session::has('danger'))
            <div class="callout callout-danger">
                {{ Session::get('danger') }}
            </div>
        @endif

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('login') ? ' has-error' : ' has-feedback' }}">
                    <label for="login">@lang('login.access')</label>
                    <input id="login" type="login" class="form-control" name="login" value="{{ old('email') }}" placeholder="example@example.com" required autofocus>
                    @if ($errors->has('login'))
                    <span class="help-block">
                        <strong>{{ $errors->first('login') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : ' has-feedback' }}">
                    <label for="password">@lang('general.userData.pass')</label>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label> <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('login.remember')</label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">@lang('login.login')</button>
                    </div>
                </div>

            </form>

            <a href="{{ route('password.request') }}">@lang('login.forgot')</a><br>

        </div>
    </div>
@endsection
