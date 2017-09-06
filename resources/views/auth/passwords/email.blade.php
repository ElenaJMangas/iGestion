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
        <form action="{{ route('password.email') }}" method="post" role="form">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">@lang('general.email')</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="example@example.com" required autofocus>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-danger btn-block btn-flat">@lang('login.passReset')</button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
