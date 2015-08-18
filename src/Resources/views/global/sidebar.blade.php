<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">

            {{-- MAIN NAVIGATION DIVIDER --}}
            <li class="header">{{ trans('laraflock.dashboard.nav.dividers.main') }}</li>

            {{-- Dashboard Links --}}
            <li class="{{ Ekko::isActiveRoute('dashboard.index') }}">
                <a href="{{ route('dashboard.index') }}">
                    <i class="fa fa-dashboard"></i> <span>{{ trans('laraflock.dashboard.nav.dashboard') }}</span>
                </a>
            </li>

            {{-- USER MANAGEMENT DIVIDER --}}
            <li class="header">{{ trans('laraflock.dashboard.nav.dividers.user') }}</li>

            {{-- User Links --}}
            <li class="{{ Ekko::areActiveRoutes(['users.index', 'users.create', 'users.edit']) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ trans('laraflock.dashboard.nav.user.title') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('users.index') }}">
                        <a href="{{ route('users.index') }}">{{ trans('laraflock.dashboard.nav.user.all') }}</a></li>
                    <li class="{{ Ekko::isActiveRoute('users.create') }}">
                        <a href="{{ route('users.create') }}">{{ trans('laraflock.dashboard.nav.user.create') }}</a></li>
                </ul>
            </li>

            {{-- Role Links --}}
            <li class="{{ Ekko::areActiveRoutes(['roles.index', 'roles.create', 'roles.edit']) }} treeview">
                <a href="#">
                    <i class="fa fa-shield"></i>
                    <span>{{ trans('laraflock.dashboard.nav.role.title') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('roles.index') }}">
                        <a href="{{ route('roles.index') }}">{{ trans('laraflock.dashboard.nav.role.all') }}</a></li>
                    <li class="{{ Ekko::isActiveRoute('roles.create') }}">
                        <a href="{{ route('roles.create') }}">{{ trans('laraflock.dashboard.nav.role.create') }}</a></li>
                </ul>
            </li>

            {{-- Permission Links --}}
            <li class="{{ Ekko::areActiveRoutes(['permissions.index', 'permissions.create', 'permissions.edit']) }} treeview">
                <a href="#">
                    <i class="fa fa-unlock-alt"></i>
                    <span>{{ trans('laraflock.dashboard.nav.permission.title') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('permissions.index') }}">
                        <a href="{{ route('permissions.index') }}">{{ trans('laraflock.dashboard.nav.permission.all') }}</a></li>
                    <li class="{{ Ekko::isActiveRoute('permissions.create') }}">
                        <a href="{{ route('permissions.create') }}">{{ trans('laraflock.dashboard.nav.permission.create') }}</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>