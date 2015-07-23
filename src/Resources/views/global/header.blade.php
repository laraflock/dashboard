<header class="main-header">
    <a href="{{ route('dashboard.index') }}" class="logo">
        <span class="logo-mini">{{ config('laraflock.dashboard.smallTitle') }}</span>
        <span class="logo-lg">{{ config('laraflock.dashboard.title') }}</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
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
                                    <small>Member since {{ Carbon::parse($activeUser->created_at)->toFormattedDateString() }}</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('account.edit') }}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        @endif
    </nav>
</header>