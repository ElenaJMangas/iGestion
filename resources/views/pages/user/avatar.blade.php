@extends('layouts.app')

@section('title', __('titles.profile'))
@section('meta_keywords','user, profile, avatar')
@section('meta_description','Profile')

@section('css')
    .imgProfile{
    width:150px;
    height:150px;
    float:left;
    border-radius:50%;
    margin-right:25px;
    }
@endsection

@section('content')
@section('header_title', __('titles.profile'))

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <img class="imgProfile" src="{{ \App\Helpers\Helper::getAvatarUser($user->avatar) }}">
        <h2>{{ $user->name }} @lang('general.profile')</h2>
        <form enctype="multipart/form-data" action="{{route('profile.update.avatar')}}" method="POST">
            <input name="_method" type="hidden" value="PUT">
            <label>@lang('general.uploadAvatar')</label>
            <input type="file" name="avatar">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="pull-right btn btn-sm btn-primary">
        </form>
    </div>
</div>
@endsection
