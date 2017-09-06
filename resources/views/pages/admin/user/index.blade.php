@extends('layouts.app')

@section('title', __('titles.usersManagement'))
@section('meta_keywords','users, management, usuarios, administracion')
@section('meta_description',__('titles.usersDescription'))

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('assets/dist/css/pages/user.css') }}">
@endsection

@section('content')
@section('header_title', __('titles.users'))
@section('header_description', __('general.management'))

{{-- Row 1 --}}
<div class="clearfix">
    <div class="pull-right top-page-ui">
        <a href="{{route('admin.user.new')}}" class="btn btn-primary pull-right">
            <i class="fa fa-plus-circle fa-lg"></i> @lang('general.addUser')
        </a>
    </div>
</div>

{{-- Row 2 --}}
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="table-users">
                <table id="users" class="table user-list table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>@choice('general.user',1)</th>
                        <th>@lang('general.role')</th>
                        <th>@lang('general.email')</th>
                        <th>@lang('general.lastLogin')</th>
                        <th>@lang('general.created')</th>
                        <th>@lang('general.status')</th>
                        <th>@lang('general.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $user->id }}
                            </td>
                            <td>
                                <img class="user-image"
                                     src="{{ \App\Helpers\Helper::getAvatarUser($user->avatar) }}"
                                     alt="{{ $user->name }}"/>
                                <a href="{{route('profile',$user->id)}}"
                                   class="user-link">{{ $user->getFullname() }}</a>
                            </td>
                            <td>
                                <span class="user-subhead">{{$user->getRole() }}</span>
                            </td>
                            <td>
                                <a href="#">{{ $user->email }}</a>
                            </td>
                            <td>
                                {{ $user->last_login }}
                            </td>
                            <td>
                                {{ $user->created_at }}
                            </td>
                            <td class="text-center">
                                <span class="label {{ $user->enable == 1 ? 'label-success' : 'label-default' }}">{{ $user->getStatus() }}</span>
                            </td>
                            <td class="actions">
                                <a href="{{route('profile',$user->id)}}" class="table-link">
                                                <span class="fa-stack" data-toggle="tooltip"
                                                      title="@choice('general.detail',2)">
                                                    <i class="fa fa-square fa-stack-2x"></i>
                                                    <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                                </span>
                                </a>
                                <a class="view-details table-link"
                                   data-url="{{ route('admin.user.new', ['id' => $user->id]) }}"
                                   href="{{ route('admin.user.new', ['id' => $user->id]) }}">
                                                            <span class="fa-stack" data-toggle="tooltip"
                                                                  title="@lang('general.update')">
                                                                <i class="fa fa-square fa-stack-2x"></i>
                                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                                            </span>
                                </a>
                                {{ Form::open(['route' => ['admin.user.delete',$user->id], 'method' => 'delete','class'=>'icons','onsubmit' => 'return confirm("'.__('general.sure').'")']) }}
                                <button type="submit" class="danger">
                                                    <span class="fa-stack" data-toggle="tooltip"
                                                          title="@lang('general.delete')">
                                                                <i class="fa fa-square fa-stack-2x"></i>
                                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                            </span>
                                </button>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_footer')
    <script src="{{ asset('assets/dist/js/pages/user.js') }}"></script>
@endsection
