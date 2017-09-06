@extends('layouts.app')

@section('title', __('general.profile'))
@section('meta_keywords','user, profile')
@section('meta_description','Profile')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('assets/dist/css/pages/profile.css') }}">
@endsection

@section('content')
@section('header_title', __('general.profile'))
@section('header_description', trans_choice('general.detail',2))

{{-- Row 1 --}}
<div class="clearfix">
    @if(Auth::user()->id == $user->id)
        <div class="pull-right top-page-ui">
            <a href="{{route('profile.update',$user->id)}}" class="btn btn-primary pull-right">
                <i class="fa fa-plus-circle fa-lg"></i> @lang('general.update')
            </a>
        </div>
    @endif
</div>
{{-- Row 2 --}}
<div class="row">
    <div class="col-lg-4">
        <div class="box box-primary">
            <div class="box-body">
                <h2>{{$user->getFullName()}}</h2>
                <div class="user-header">
                    <a href="@if(Auth::user()->id == $user->id){{route('profile.avatar')}} @endif"><img
                                src="{{ \App\Helpers\Helper::getAvatarUser($user->avatar) }}" class="img-circle"
                                alt="User Image"></a>
                </div>
                <div class="profile-label">
                    <span class="label label-danger"> {{$user->getRole()}}</span>
                </div>
                <div class="profile-since">
                    @lang('general.memberSince') {{ App\Helpers\Helper::getMonth($user->created_at) . ". " . App\Helpers\Helper::getYear($user->created_at)}}
                </div>
                <div class="profile-details">
                    <ul class="fa-ul">
                        <li><i class="fa-li fa fa-briefcase"></i>@choice('general.project',2):
                            <span>{{$projects}}</span></li>
                        <li><i class="fa-li fa fa-comment"></i>@choice('general.comment',2): <span>{{$comments}}</span>
                        </li>
                        <li><i class="fa-li fa fa-tasks"></i>@lang('task.doneTasks'): <span>{{$done}}</span></li>
                    </ul>
                </div>
                <div class="profile-message-btn center-block text-center">
                    <a href="{{route('compose')}}" class="btn btn-success">
                        <i class="fa fa-envelope"></i>
                        @lang('general.sendMessage')
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('general.userInfo')</h3>
            </div>
            <div class="box-body">
                <div class="col-sm-8">
                    <div class="profile-user-details clearfix">
                        <div class="profile-user-details-label">
                            @lang('general.userData.name')
                        </div>
                        <div class="profile-user-details-value">
                            {{$user->name}}
                        </div>
                    </div>
                    <div class="profile-user-details clearfix">
                        <div class="profile-user-details-label">
                            @lang('general.userData.surname')
                        </div>
                        <div class="profile-user-details-value">
                            {{$user->surname}}
                        </div>
                    </div>
                    <div class="profile-user-details clearfix">
                        <div class="profile-user-details-label">
                            @lang('general.userData.username')
                        </div>
                        <div class="profile-user-details-value">
                            {{$user->username}}
                        </div>
                    </div>
                    <div class="profile-user-details clearfix">
                        <div class="profile-user-details-label">
                            @lang('general.email')
                        </div>
                        <div class="profile-user-details-value">
                            {{$user->email}}
                        </div>
                    </div>
                    <div class="profile-user-details clearfix">
                        <div class="profile-user-details-label">
                            @lang('general.enabled')
                        </div>
                        <div class="profile-user-details-value">
                            {{($user->enable == 1) ? __('general.enabled') : __('general.disabled')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
