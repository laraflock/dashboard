<?php

/**
 * @package     Dashboard
 * @version     2.0.0
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as Base;
use Laraflock\Dashboard\Providers\DashboardServiceProvider;

class TestCase extends Base
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected $session;
    protected $authRepository;
    protected $permissionRepository;
    protected $roleRepository;
    protected $userRepository;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        // Require Laravel bootstrap application.
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        // Make the application and bootstrap.
        $app->make(Kernel::class)
            ->bootstrap();

        // Register this package to the application.
        $app->register(DashboardServiceProvider::class);

        // Return the application.
        return $app;
    }

    /**
     * Sets up the application.
     */
    public function setUp()
    {
        // Run parent class set up method.
        parent::setUp();

        // Delete default laravel migrations in order to use Sentinel.
        $this->artisan('dashboard:fresh');

        // Publish Vendor Assets + Configs
        $this->artisan('vendor:publish');

        // Refresh application.
        $this->refreshApplication();

        // Setup Configuration to work with Laravel for testing.
        config([
          'database.connections.sqlite.database' => env('DB_DATABASE'),
        ]);

        // Run migrations.
        $this->artisan('migrate');

        $this->authRepository       = app()->make('Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface');
        $this->permissionRepository = app()->make('Laraflock\Dashboard\Repositories\Permission\PermissionRepositoryInterface');
        $this->roleRepository       = app()->make('Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface');
        $this->userRepository       = app()->make('Laraflock\Dashboard\Repositories\User\UserRepositoryInterface');
    }

    public function tearDown()
    {
        // Uninstall Dashboard
        $this->artisan('dashboard:uninstall');

        // Run parent class tear down method.
        parent::tearDown();
    }

    /**
     * Testing Laravel application.
     */
    public function testLaravel()
    {
        $this->visit('/')
             ->see('Laravel 5');
    }
}