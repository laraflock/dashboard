<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">

            {{-- MAIN NAVIGATION DIVIDER --}}
            <li class="header">{{ trans('dashboard::dashboard.nav.dividers.main') }}</li>

            {{-- Dashboard Links --}}
            <li class="{{ Ekko::isActiveRoute('dashboard.index') }}">
                <a href="{{ route('dashboard.index') }}">
                    <i class="fa fa-dashboard"></i> <span>{{ trans('dashboard::dashboard.nav.dashboard') }}</span>
                </a>
            </li>

            {{-- USER MANAGEMENT DIVIDER --}}
            <li class="header">{{ trans('dashboard::dashboard.nav.dividers.user') }}</li>

            {{-- User Links --}}
            <li class="{{ Ekko::areActiveRoutes(['users.index', 'users.create', 'users.edit']) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ trans('dashboard::dashboard.nav.user.title') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('users.index') }}">
                        <a href="{{ route('users.index') }}">{{ trans('dashboard::dashboard.nav.user.all') }}</a></li>
                    <li class="{{ Ekko::isActiveRoute('users.create') }}">
                        <a href="{{ route('users.create') }}">{{ trans('dashboard::dashboard.nav.user.create') }}</a></li>
                </ul>
            </li>

            {{-- Role Links --}}
            <li class="{{ Ekko::areActiveRoutes(['roles.index', 'roles.create', 'roles.edit']) }} treeview">
                <a href="#">
                    <i class="fa fa-shield"></i>
                    <span>{{ trans('dashboard::dashboard.nav.role.title') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('roles.index') }}">
                        <a href="{{ route('roles.index') }}">{{ trans('dashboard::dashboard.nav.role.all') }}</a></li>
                    <li class="{{ Ekko::isActiveRoute('roles.create') }}">
                        <a href="{{ route('roles.create') }}">{{ trans('dashboard::dashboard.nav.role.create') }}</a></li>
                </ul>
            </li>

            {{-- Permission Links --}}
            <li class="{{ Ekko::areActiveRoutes(['permissions.index', 'permissions.create', 'permissions.edit']) }} treeview">
                <a href="#">
                    <i class="fa fa-unlock-alt"></i>
                    <span>{{ trans('dashboard::dashboard.nav.permission.title') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('permissions.index') }}">
                        <a href="{{ route('permissions.index') }}">{{ trans('dashboard::dashboard.nav.permission.all') }}</a></li>
                    <li class="{{ Ekko::isActiveRoute('permissions.create') }}">
                        <a href="{{ route('permissions.create') }}">{{ trans('dashboard::dashboard.nav.permission.create') }}</a></li>
                </ul>
            </li>
            @foreach($modules->getRegistered() as $module)
                <li class="header">{{ $module->getName() }}</li>
                @foreach($module->getMenuItems() as $label => $linkOptions)
                    <li>
                        <a href="{{ array_get($linkOptions, 'href', '#') }}">
                            @if(array_get($linkOptions, 'icon'))
                                @if(strstr(array_get($linkOptions, 'icon'), ':'))
                                    @include(array_get($linkOptions, 'icon'))
                                @else
                                    <i class="{{ array_get($linkOptions, 'icon') }}"></i>
                                @endif
                            @endif
                            <span>{{ $label }}</span>
                            @if(array_get($linkOptions, 'items'))
                                <i class="fa fa-angle-left pull-right"></i>
                            @endif
                        </a>
                        @if(array_get($linkOptions, 'items'))
                            <ul class="treeview-menu">
                                @foreach(array_get($linkOptions, 'items', []) as $label => $linkOptions)
                                    <li>
                                        <a href="{{ array_get($linkOptions, 'href', '#') }}">
                                            @if(array_get($linkOptions, 'icon'))
                                                @if(strstr(array_get($linkOptions, 'icon'), ':'))
                                                    @include(array_get($linkOptions, 'icon'))
                                                @else
                                                    <i class="{{ array_get($linkOptions, 'icon') }}"></i>
                                                @endif
                                            @endif
                                            <span>{{ $label }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endforeach
        </ul>
    </section>
</aside>