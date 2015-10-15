<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Providers;

use AdamWathan\BootForms\BootFormsServiceProvider;
use AdamWathan\BootForms\Facades\BootForm;
use AdamWathan\Form\Facades\Form;
use AdamWathan\Form\FormServiceProvider;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\SentinelServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laracasts\Flash\Flash;
use Laracasts\Flash\FlashServiceProvider;
use Laravelista\Ekko\EkkoServiceProvider;
use Laravelista\Ekko\Facades\Ekko;
use Laraflock\Dashboard\Commands\FreshCommand;
use Laraflock\Dashboard\Commands\InstallerCommand;
use Laraflock\Dashboard\Commands\SetupCommand;
use Laraflock\Dashboard\Commands\UninstallCommand;
use Laraflock\Dashboard\Middleware\UserMiddleware;
use Laraflock\Dashboard\Middleware\RoleMiddleware;
use Laraflock\Dashboard\Middleware\PermissionMiddleware;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        // Setup Default namespace until config file is published.
        if (!$namespace = config('laraflock.dashboard.viewNamespace')) {
            $namespace = 'dashboard';
        }

        // Load & Publish views.
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', $namespace);
        $this->publishes([
          __DIR__ . '/../Resources/views' => base_path('resources/views/vendor/' . $namespace),
        ], 'views');

        // Load translations.
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'dashboard');

        // Publish config.
        $config = realpath(__DIR__ . '/../config.php');

        $this->mergeConfigFrom($config, 'laraflock.dashboard');

        $this->publishes([
            $config => config_path('laraflock.dashboard.php'),
        ], 'config');

        // Use package routes.
        if (config('laraflock.dashboard.routes')) {
            include __DIR__ . '/../routes.php';
        }

        // Publish migrations.
        $migrations = realpath(__DIR__ . '/../Database/Migrations');

        $this->publishes([
          $migrations => database_path('/migrations'),
        ], 'migrations');

        // Publish assets.
        $this->publishes([
          __DIR__ . '/../Resources/assets' => public_path('vendor/laraflock'),
        ], 'public');

        // Setup interfaces.
        $this->setupInterfaces();
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->setupProviders();
        $this->setupFacades();
        $this->setupConsoleCommands();
        $this->setupMiddleware();
    }

    /**
     * Register the middleware to the application
     *
     * Register the following middleware:
     * - \Laraflock\Dashboard\Middleware\UserMiddleware
     * - \Laraflock\Dashboard\Middleware\RoleMiddleware
     * - \Laraflock\Dashboard\Middleware\PermissionMiddleware
     */
    protected function setupMiddleware()
    {
        $this->app['router']->middleware('user', UserMiddleware::class);
        $this->app['router']->middleware('roles', RoleMiddleware::class);
        $this->app['router']->middleware('permissions', PermissionMiddleware::class);
    }

    /**
     * Register the providers to the application.
     *
     * This will register packages that this package is dependent on.
     *
     * Register the following providers:
     * - Sentinel
     * - Ekko
     * - Flash
     * - Form
     * - BootForm
     */
    protected function setupProviders()
    {
        // Register Sentinel Package
        // - Used for authentication, authorization, roles, and permissions.
        $this->app->register(SentinelServiceProvider::class);

        // Register Ekko Package
        // - Used for blade templates to trigger active classes for navigation items.
        $this->app->register(EkkoServiceProvider::class);

        // Register Flash Package
        // - Used for easy flash session notifications and messages.
        $this->app->register(FlashServiceProvider::class);

        // Register Form Package
        // - Used for HTML form building with easy and readable API.
        $this->app->register(FormServiceProvider::class);

        // Register Bootstrap Form Package
        // - Used for HTML form building with easy and readable API (Bootstrap 3).
        $this->app->register(BootFormsServiceProvider::class);
    }

    /**
     * Register Interface Bindings
     */
    protected function setupInterfaces()
    {
        // Bind the Auth Repository Interface
        $this->app->bind(
          'Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface',
          config('laraflock.dashboard.authRepositoryClass')
        );

        // Bind the Permission Repository Interface
        $this->app->bind(
          'Laraflock\Dashboard\Repositories\Permission\PermissionRepositoryInterface',
          config('laraflock.dashboard.permissionRepositoryClass')
        );

        // Bind the Role Repository Interface
        $this->app->bind(
          'Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface',
          config('laraflock.dashboard.roleRepositoryClass')
        );

        // Bind the User Repository Interface
        $this->app->bind(
          'Laraflock\Dashboard\Repositories\User\UserRepositoryInterface',
          config('laraflock.dashboard.userRepositoryClass')
        );

        // Bind the Module Repository Interface
        $this->app->singleton(
            'Laraflock\Dashboard\Repositories\Module\ModuleRepositoryInterface',
            config('laraflock.dashboard.moduleRepositoryClass')
        );
    }

    /**
     * Register the console commands to the application.
     *
     * Register the following commands:
     * - dashboard:install
     * - dashboard:fresh
     */
    protected function setupConsoleCommands()
    {
        // Share dashboard:install command with the application.
        $this->app['dashboard::install'] = $this->app->share(function () {
            return new InstallerCommand();
        });

        // Share dashboard:setup command with the application.
        $this->app['dashboard::setup'] = $this->app->share(function () {
            return new SetupCommand();
        });

        // Share dashboard:fresh command with the application.
        $this->app['dashboard::fresh'] = $this->app->share(function () {
            return new FreshCommand();
        });

        // Share dashboard:uninstall command with the application.
        $this->app['dashboard::uninstall'] = $this->app->share(function () {
            return new UninstallCommand();
        });

        // Adds dashboard:install to the console kernel.
        $this->commands('dashboard::install');

        // Adds dashboard:setup to the console kernel.
        $this->commands('dashboard::setup');

        // Adds dashboard:fresh to the console kernel.
        $this->commands('dashboard::fresh');

        // Adds dashboard:uninstall to the console kernel.
        $this->commands('dashboard::uninstall');
    }

    /**
     * Register the Facades to the application.
     *
     * Registers the following facades:
     * - Activation
     * - Reminder
     * - Sentinel
     * - Flash
     * - Ekko
     * - Form
     * - BootForm
     */
    protected function setupFacades()
    {
        // Setup alias loader.
        $loader = AliasLoader::getInstance();

        // Load Sentinel
        // - Activation
        // - Reminder
        // - Sentinel
        $loader->alias('Activation', Activation::class);
        $loader->alias('Reminder', Reminder::class);
        $loader->alias('Sentinel', Sentinel::class);

        // Load Flash
        $loader->alias('Flash', Flash::class);

        // Load Ekko
        $loader->alias('Ekko', Ekko::class);

        // Carbon
        $loader->alias('Carbon', Carbon::class);

        // Load Form
        // - Form
        // - BootForm
        $loader->alias('Form', Form::class);
        $loader->alias('BootForm', BootForm::class);
    }
}