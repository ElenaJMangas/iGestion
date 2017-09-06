@extends('layouts.app')

@section('title', __('titles.usersManagement'))
@section('meta_keywords',__('titles.usersKeywords'))
@section('meta_description',__('titles.usersDescription'))

@section('pagecss')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/iCheck/square/blue.css') }}">
@endsection

@section('css')
    .checkbox label{
    padding-left:  0px;
    }
@endsection

@section('content')
@section('header_title', 'Users')
@section('header_description', __('general.new'))

{{-- Row 1 --}}
<div class="row">
    <div class="col-md-12" id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@choice('general.detail',2)</h3>
                    </div>
                    <form class="form-horizontal" role="form"
                          action="{{route('admin.user.new', isset($user->id) ? $user->id : NULL)}}" method="POST">
                        {{ csrf_field() }}
                        @if(isset($user->id))
                            <input name="_method" type="hidden" value="PUT">
                        @endif
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-2 control-label">@lang('general.userData.name')</label>

                                <div class="col-sm-10">
                                    <input type="text" name='name'
                                           value="{{ isset($user->name) ?  $user->name : old('name')  }}"
                                           class="form-control" id="name" placeholder="@lang('general.userData.name')" required
                                           pattern="([a-zA-ZÁÉÍÓÚñáéíóú]+[\s]*){3,}"
                                           title="@lang('general.typename',['num'=>3])">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('surname') ? ' has-error' : '' }}">
                                <label for="surname" class="col-sm-2 control-label">@lang('general.userData.surname')</label>

                                <div class="col-sm-10">
                                    <input type="text" name='surname'
                                           value="{{ isset($user->surname) ?  $user->surname : old('surname')  }}"
                                           class="form-control" id="surname" placeholder="@lang('general.userData.surname')"
                                           required pattern="([a-zA-ZÁÉÍÓÚñáéíóú]+[\s]*){3,}"
                                           title="@lang('general.typename',['num'=>3])">
                                    @if ($errors->has('surname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('surname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-sm-2 control-label">@lang('general.userData.username')</label>

                                <div class="col-sm-10">
                                    <input type="text" name='username'
                                           value="{{ isset($user->username) ?  $user->username : old('username')  }}"
                                           class="form-control" id="username" placeholder="@lang('general.userData.username')"
                                           required pattern="[a-zA-Z]+[a-zA-Z0-9]{2,}"
                                           title="@lang('general.typeUsername',['num'=>3])">
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-sm-2 control-label">@lang('general.email')</label>

                                <div class="col-sm-10">
                                    <input type="email" name='email'
                                           value="{{ isset($user->email) ?  $user->email : old('email') }}"
                                           class="form-control" id="email" placeholder="@lang('general.email')"
                                           required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-sm-2 control-label">@lang('general.userData.pass')</label>

                                <div class="col-sm-10">
                                    <input @if(!isset($user)) required @endif type="password" name='password' class="form-control" id="password"
                                           placeholder="@lang('general.userData.pass')"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="new-password"
                                           title="@lang('general.typePass',['num'=>8])">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password_confirmation"
                                       class="col-sm-2 control-label">@lang('general.userData.passConfirm')</label>

                                <div class="col-sm-10">
                                    <input type="password" name='password_confirmation' class="form-control"
                                           id="password_confirmation" placeholder="@lang('general.userData.passConfirm')"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="new-password"
                                           title="@lang('general.typePass',['num'=>8])">
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
                                <label for="role" class="col-sm-2 control-label">@lang('general.role')</label>
                                <div class="col-sm-10">
                                    {{ Form::select('role', $roles, isset($user->role_id) ? $user->role_id : old('role'), ['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            {{ Form::checkbox('enable', null, (isset($user->enable) && $user->enable == 1) ) }}@lang('general.enabled')
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="{{route('admin.user')}}" class="btn btn-default">@lang('general.cancel')</a>
                            <button type="submit" class="btn btn-primary pull-right">@lang('general.save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_footer')
    <!-- iCheck -->
    <script src="{{ asset('assets/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/icheck.js') }}"></script>
@endsection
