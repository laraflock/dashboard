<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    |
    | Display version of the application in the footer of the dashboard. This
    | is not in the reference of the actual package, this is what version of
    | the application you are building is.
    |
    */

    'version'                   => '1.0',
    /*
    |--------------------------------------------------------------------------
    | Dashboard Title
    |--------------------------------------------------------------------------
    |
    | This is used in the top left of the Admin LTE template, it is used as
    | the main title of the dashboard panel itself.
    |
    */

    'title'                     => 'Dashboard',
    /*
    |--------------------------------------------------------------------------
    | Small Dashboard Title
    |--------------------------------------------------------------------------
    |
    | This is used in the top left of the Admin LTE template when sidebar-mini
    | class has been added to the body tag.
    |
    */

    'smallTitle'                => 'Dash',
    /*
    |--------------------------------------------------------------------------
    | Footer Credits
    |--------------------------------------------------------------------------
    |
    | By default this will be used for the copyright on the inside of the
    | admin panel. This will also output the current year so the copyright
    | stays up to date, you can easily override this inside the view itself.
    |
    */

    'credits'                   => 'Laraflock',
    /*
    |--------------------------------------------------------------------------
    | Default Role on User Creation
    |--------------------------------------------------------------------------
    |
    | By default the role that a user is assigned to during registration
    | or user creation from the admin panel. The default role is setup
    | during the dashboard:install or dashboard:setup CLI commands.
    |
    */

    'defaultRole'               => 'registered',
    /*
    |--------------------------------------------------------------------------
    | User Registration
    |--------------------------------------------------------------------------
    |
    | By default the user registration is turned off. This would be set if
    | you would like to have public users be able to create an account using
    | a registration form. This will create a user and depending on the
    | config setting below for activations will either activate the account
    | or not activate the account upon successful registration.
    |
    */

    'registration'              => false,
    /*
    |--------------------------------------------------------------------------
    | User Activations
    |--------------------------------------------------------------------------
    |
    | By default user activations are turned off. This is a built in feature
    | in Cartalyst\Sentinel that would require activation of a user account
    | before a user can login. This is usually sent via email to a user
    | with a link to submit the activation code.
    |
    */

    'activations'               => false,
    /*
    |--------------------------------------------------------------------------
    | Package routes
    |--------------------------------------------------------------------------
    |
    | By default this packages routes will be used, if you would like to
    | change any major workflows, you can set this to false and setup
    | your custom routes and controllers inside the application. You can
    | copy and paste the routes from this package so default routes that
    | are called will still be available.
    |
    */

    'routes'                    => true,
    /*
    |--------------------------------------------------------------------------
    | Override the View Namespace
    |--------------------------------------------------------------------------
    |
    | Override the default view namespace to be used for this packages views.
    |
    */

    'viewNamespace'             => 'dashboard',
    /*
    |--------------------------------------------------------------------------
    | Auth Repository Class
    |--------------------------------------------------------------------------
    |
    | Use package auth repository class, or use your own. This will
    | automatically bind inside the service provider.
    |
    | Default Repository: Laraflock\Dashboard\Repositories\Auth\AuthRepository
    |
    | * NOTICE *
    | If you would like to use your own repository class, be sure to implement
    | the following interface and extend the base repository class:
    |
    | Base Repository: Laraflock\Dashboard\Repositories\Base\BaseRepository
    | Auth Interface: Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface
    |
    */

    'authRepositoryClass'       => 'Laraflock\Dashboard\Repositories\Auth\AuthRepository',
    /*
    |--------------------------------------------------------------------------
    | Permission Repository Class
    |--------------------------------------------------------------------------
    |
    | Use package permission repository class, or use your own. This will
    | automatically bind inside the service provider.
    |
    | Default Repository: Laraflock\Dashboard\Repositories\Permission\PermissionRepository
    |
    | * NOTICE *
    | If you would like to use your own repository class, be sure to implement
    | the following interface and extend the base repository class:
    |
    | Base Repository: Laraflock\Dashboard\Repositories\Base\BaseRepository
    | Permission Interface: Laraflock\Dashboard\Repositories\Permission\PermissionRepositoryInterface
    |
    */

    'permissionRepositoryClass' => 'Laraflock\Dashboard\Repositories\Permission\PermissionRepository',
    /*
    |--------------------------------------------------------------------------
    | Role Repository Class
    |--------------------------------------------------------------------------
    |
    | Use package role repository class, or use your own. This will
    | automatically bind inside the service provider.
    |
    | Default Repository: Laraflock\Dashboard\Repositories\Role\RoleRepository
    |
    | * NOTICE *
    | If you would like to use your own repository class, be sure to implement
    | the following interface and extend the base repository class:
    |
    | Base Repository: Laraflock\Dashboard\Repositories\Base\BaseRepository
    | Role Interface: Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface
    |
    */

    'roleRepositoryClass'       => 'Laraflock\Dashboard\Repositories\Role\RoleRepository',
    /*
    |--------------------------------------------------------------------------
    | User Repository Class
    |--------------------------------------------------------------------------
    |
    | Use package user repository class, or use your own. This will
    | automatically bind inside the service provider.
    |
    | Default Repository: Laraflock\Dashboard\Repositories\User\UserRepository
    |
    | * NOTICE *
    | If you would like to use your own repository class, be sure to implement
    | the following interface and extend the base repository class:
    |
    | Base Repository: Laraflock\Dashboard\Repositories\Base\BaseRepository
    | User Interface: Laraflock\Dashboard\Repositories\User\UserRepositoryInterface
    |
    */

    'userRepositoryClass'       => 'Laraflock\Dashboard\Repositories\User\UserRepository',

    /*
    |--------------------------------------------------------------------------
    | Module Repository Class
    |--------------------------------------------------------------------------
    |
    | Use package module repository class, or use your own. This will
    | automatically bind inside the service provider. If left blank the
    | default repository class will be loaded.
    |
    | Default Repository: Laraflock\Dashboard\Repositories\Module\ModuleRepository
    |
    | * NOTICE *
    | If you would like to use your own repository class, be sure to implement
    | the following interface and extend the base repository class:
    |
    | Module Repository Interface: Laraflock\Dashboard\Repositories\Module\ModuleRepositoryInterface
    |
     */
    'moduleRepositoryClass'     => 'Laraflock\Dashboard\Repositories\Module\ModuleRepository',

    /*
    |--------------------------------------------------------------------------
    | AdminLTE Theme
    |--------------------------------------------------------------------------
    |
    | You will be able to decide easily which theme you want to load for the
    | AdminLTE Dashboard template. There are multiple colors to choose from
    | that are already pre-built, or you can create your own as well. The
    | following themes are available by default:
    |
    | - skin-black-light
    | - skin-black
    | - skin-blue-light
    | - skin-blue
    | - skin-green-light
    | - skin-green
    | - skin-purple-light
    | - skin-purple
    | - skin-red-light
    | - skin-red
    | - skin-yellow-light
    | - skin-yellow
    |
    */

    'theme'                     => 'skin-blue',
];
