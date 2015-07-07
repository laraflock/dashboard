<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Providers;

use AdamWathan\BootForms\BootFormsServiceProvider;
use AdamWathan\BootForms\Facades\BootForm;
use AdamWathan\Form\Facades\Form;
use AdamWathan\Form\FormServiceProvider;
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
use Odotmedia\Dashboard\Commands\FreshCommand;
use Odotmedia\Dashboard\Commands\InstallerCommand;
use Odotmedia\Dashboard\Commands\UninstallCommand;
use Odotmedia\Dashboard\Middleware\UserMiddleware;
use Odotmedia\Dashboard\Middleware\RoleMiddleware;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        // Load & Publish views.
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'dashboard');
        $this->publishes([
          __DIR__ . '/../Resources/views' => base_path('resources/views/vendor/dashboard'),
        ]);

        // Use package routes.
        if (config('odotmedia.dashboard.routes')) {
            include __DIR__ . '/../routes.php';
        }

        // Publish config.
        $config = realpath(__DIR__ . '/../config.php');

        $this->mergeConfigFrom($config, 'odotmedia.dashboard');

        $this->publishes([
          $config => config_path('odotmedia.dashboard.php'),
        ], 'config');

        // Publish migrations.
        $migrations = realpath(__DIR__ . '/../Database/Migrations');

        $this->publishes([
          $migrations => database_path('/migrations'),
        ], 'migrations');

        // Publish assets.
        $this->publishes([
          __DIR__ . '/../Resources/assets' => public_path('vendor/odotmedia'),
        ], 'public');
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
     * - \Odotmedia\Dashboard\Middleware\UserMiddleware
     * - \Odotmedia\Dashboard\Middleware\RoleMiddleware
     */
    protected function setupMiddleware()
    {
        $this->app['router']->middleware('user', UserMiddleware::class);
        $this->app['router']->middleware('roles', RoleMiddleware::class);
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

        // Load Form
        // - Form
        // - BootForm
        $loader->alias('Form', Form::class);
        $loader->alias('BootForm', BootForm::class);
    }
}