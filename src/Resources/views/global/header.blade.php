<header class="main-header">
    <a href="{{ route('dashboard.index') }}" class="logo">
        <span class="logo-mini">{{ trans('dashboard::dashboard.global.small_title') }}</span>
        <span class="logo-lg">{{ trans('dashboard::dashboard.global.title') }}</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('dashboard::dashboard.global.toggle_nav') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        @if ($activeUser)
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ '//www.gravatar.com/avatar/' . md5($activeUser->email) . '?s=160' }}" class="user-image" alt="{{ $activeUser->first_name }} {{ $activeUser->last_name }}"/>
                            <span class="hidden-xs">{{ $activeUser->first_name }} {{ $activeUser->last_name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ '//www.gravatar.com/avatar/' . md5($activeUser->email) . '?s=160' }}" class="img-circle" alt="{{ $activeUser->first_name }} {{ $activeUser->last_name }}"/>

                                <p>
                                    {{ $activeUser->first_name }} {{ $activeUser->last_name }}
                                    <small>{{ trans('dashboard::dashboard.header.member_since') }} {{ Carbon::parse($activeUser->created_at)->toFormattedDateString() }}</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('account.edit') }}" class="btn btn-default btn-flat">{{ trans('dashboard::dashboard.buttons.profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat">{{ trans('dashboard::dashboard.buttons.logout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        @endif
    </nav>
</header>