<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('dashboard.index') }}" class="{{ Ekko::isActiveRoute('dashboard.index') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#" class="{{ Ekko::areActiveRoutes(['users.index', 'users.create']) }}"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('users.index') }}" class="{{ Ekko::isActiveRoute('users.index') }}">All Users</a>
                    </li>
                    <li>
                        <a href="{{ route('users.create') }}" class="{{ Ekko::isActiveRoute('users.create') }}">Add New User</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="{{ Ekko::areActiveRoutes(['roles.index', 'roles.create']) }}"><i class="fa fa-shield fa-fw"></i> Roles<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('roles.index') }}" class="{{ Ekko::isActiveRoute('roles.index') }}">All Roles</a>
                    </li>
                    <li>
                        <a href="{{ route('roles.create') }}" class="{{ Ekko::isActiveRoute('roles.create') }}">Add New Role</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="{{ Ekko::areActiveRoutes(['permissions.index', 'permissions.create']) }}"><i class="fa fa-unlock-alt fa-fw"></i> Permissions<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('permissions.index') }}" class="{{ Ekko::isActiveRoute('permissions.index') }}">All Permissions</a>
                    </li>
                    <li>
                        <a href="{{ route('permissions.create') }}" class="{{ Ekko::isActiveRoute('permissions.create') }}">Add New Permission</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>