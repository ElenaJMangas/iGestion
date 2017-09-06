<div class="main-sidebar">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">@lang('general.mainNavigation')</li>
            <li {{ App\Helpers\Helper::active_if('index') }}><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> <span>@lang('general.dashboard')</span></a></li>
            <li {{ App\Helpers\Helper::active_if('projects') }}><a href="{{ route('projects') }}"><i class="fa fa-briefcase"></i> <span>@choice('general.project',2)</span></a></li>
            <li {{ App\Helpers\Helper::active_if('calendar') }}><a href="{{ route('calendar') }}"><i class="fa fa-calendar"></i> <span>@lang('general.calendar')</span></a></li>
            <li {{ App\Helpers\Helper::active_if('tasks') }}><a href="{{ route('tasks') }}"><i class="fa fa-tasks"></i> <span>@choice('general.task',2)</span></a></li>
            <li {{ App\Helpers\Helper::active_if('messages') }}><a href="{{ route('messages') }}"><i class="fa fa-envelope-o"></i> <span>@choice('general.msg',2)</span></a></li>
            @if (isset(\Auth::user()->id) && \Auth::user()->isAdmin())
                <li {{  App\Helpers\Helper::active_if('user') }}><a href="{{ route ('admin.user')}}"><i class="fa fa-users"></i> <span>@choice('general.user',2)</span></a></li>
            @endif
        </ul>
    </div>
</div>