<header class="main-header">
    <a href="{{ route('index') }}" class="logo">
        <span class="logo-mini"><i class="fa fa-home"></i></span>
        <span class="logo-lg">iGestion</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu" style="width: auto !important;">
                        <li class="header">@lang('general.selectLang')</li>
                        <li>
                            <a href="{{ route('switch.lang', 'en') }}">
                                <img width="24"
                                     src="{{ asset('assets/dist/img/flags/english.png') }}"> @lang('general.english')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('switch.lang', 'es') }}">
                                <img width="24"
                                     src="{{ asset('assets/dist/img/flags/spanish.png') }}"> @lang('general.spanish')
                            </a>
                        </li>
                    </ul>


                </li>
                @if (isset(\Auth::user()->id))
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="getNotifications">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning"
                                  id="totalNotifications">{{ \App\Models\Notification::getNotRead() }}</span>
                        </a>
                        <ul class="dropdown-menu" id="menuNotifications">
                            @include('partials.notifications')
                        </ul>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ \App\Helpers\Helper::getAvatarUser(Auth::user()->avatar) }}" class="user-image"
                                 alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->getFullName() }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ \App\Helpers\Helper::getAvatarUser(Auth::user()->avatar) }}"
                                     class="img-circle"
                                     alt="User Image">
                                <p>
                                    {{Auth::user()->getFullName() . " - " . Auth::user()->getRole()}}
                                    <small>@lang('general.memberSince') {{ App\Helpers\Helper::getMonth(Auth::user()->created_at) . ". " . App\Helpers\Helper::getYear(Auth::user()->created_at) }}</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('profile',Auth::user()->id) }}"
                                       class="btn btn-default btn-flat">@lang('general.profile')</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}"
                                       class="btn btn-default btn-flat">@lang('general.logout')</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>

    </nav>
</header>