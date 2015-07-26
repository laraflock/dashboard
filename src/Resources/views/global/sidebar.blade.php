<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ Ekko::isActiveRoute('dashboard.index') }}">
                <a href="{{ route('dashboard.index') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="header">USER MANAGEMENT</li>
            <li class="{{ Ekko::areActiveRoutes(['users.index', 'users.create']) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('users.index') }}">
                        <a href="{{ route('users.index') }}">All Users</a></li>
                    <li class="{{ Ekko::isActiveRoute('users.create') }}">
                        <a href="{{ route('users.create') }}">Add New User</a></li>
                </ul>
            </li>
            <li class="{{ Ekko::areActiveRoutes(['roles.index', 'roles.create']) }} treeview">
                <a href="#">
                    <i class="fa fa-shield"></i>
                    <span>Roles</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('roles.index') }}">
                        <a href="{{ route('roles.index') }}">All Roles</a></li>
                    <li class="{{ Ekko::isActiveRoute('roles.create') }}">
                        <a href="{{ route('roles.create') }}">Add New Role</a></li>
                </ul>
            </li>
            <li class="{{ Ekko::areActiveRoutes(['permissions.index', 'permissions.create']) }} treeview">
                <a href="#">
                    <i class="fa fa-unlock-alt"></i>
                    <span>Permissions</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('permissions.index') }}">
                        <a href="{{ route('permissions.index') }}">All Permissions</a></li>
                    <li class="{{ Ekko::isActiveRoute('permissions.create') }}">
                        <a href="{{ route('permissions.create') }}">Add New Permission</a></li>
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