@extends('layouts.login')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('login') }}"><b>@lang('login.reset')</b></a>
    </div>

    <div class="login-box-body">
        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
        <form action="{{ route('password.request') }}" method="post" role="form">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">@lang('general.email')</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="example@example.com" required autofocus>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">@lang('general.userData.pass')</label>
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            
            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password_confirmation">@lang('general.userData.pass')</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Password" required>
                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-danger btn-block btn-flat">@lang('login.reset')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
