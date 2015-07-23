<?php

/**
 * @package     Dashboard
 * @version     2.0.0
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs Dashboard migrations, configs, views, assets.';

    /**
     * The database information entered by the user.
     *
     * @var array
     */
    protected $database = array();

    /**
     * The default user to setup.
     *
     * @var array
     */
    protected $user = array();

    /**
     * Auth interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Auth\AuthRepository
     */
    protected $authRepository;

    /**
     * Permission interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Permission\PermissionRepository
     */
    protected $permissionRepository;

    /**
     * Role interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Role\RoleRepository
     */
    protected $roleRepository;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->authRepository       = app()->make('Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface');
        $this->permissionRepository = app()->make('Laraflock\Dashboard\Repositories\Permission\PermissionRepositoryInterface');
        $this->roleRepository       = app()->make('Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface');

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->showWelcomeMessage();
        $this->databaseSetup();
        $this->userSetup();
        $this->setupEnvFile();
        $this->triggerPublish();
        $this->call('dashboard:fresh');
        $this->triggerMigrations();
        $this->createDefaultUser();
        $this->info('Setup is complete. Keep coding!');
    }

    /**
     * Get database data that user input during CLI installation.
     *
     * @return array
     */
    protected function getDatabaseData()
    {
        return $this->database;
    }

    /**
     * Get user data that user input during CLI installation.
     *
     * @return array
     */
    protected function getUserData()
    {
        return $this->user;
    }

    /**
     * Shows the welcome message.
     *
     * @return void
     */
    protected function showWelcomeMessage()
    {
        $this->output->writeln(<<<WELCOME
<fg=white>
*-----------------------------------------------*
|                                               |
|               Dashboard Installer             |
|               Copyright (c) 2015              |
|                   Laraflock                   |
|                                               |
|          Thanks for using Dashboard!          |
|                                               |
*-----------------------------------------------*
</fg=white>
WELCOME
        );
    }

    /**
     * Setup the database credentials.
     *
     * @return void
     */
    protected function databaseSetup()
    {
        $this->output->writeln(<<<STEP
<fg=yellow>
*-----------------------------------------------*
|                                               |
|              Configure Database               |
|         This package uses MySQL Only          |
|                                               |
*-----------------------------------------------*
</fg=yellow>
STEP
        );

        $host = $this->anticipate('Please enter the database host',
          ['localhost']);
        $name = $this->anticipate('Please enter the database name',
          ['homestead']);
        $user = $this->anticipate('Please enter the database user',
          ['homestead']);
        $pass = $this->databaseSetupPassword();

        $headers = [
          'Setting',
          'Value',
        ];

        $data = [
          ['Host', $host],
          ['Name', $name],
          ['User', $user],
          ['Password', $pass],
        ];

        $this->table($headers, $data);

        if (!$this->confirm('Is the database info correct?')) {
            $this->databaseSetup();
        }

        $this->database = [
          'host' => $host,
          'name' => $name,
          'user' => $user,
          'pass' => $pass,
        ];

        $this->info('Database configuration saved.');
    }

    /**
     * Setup the database credentials password.
     *
     * @return string
     */
    protected function databaseSetupPassword()
    {
        $pass        = $this->secret('Please enter the database password');
        $passConfirm = $this->secret('Please confirm the database password');

        if ($pass != $passConfirm) {
            $this->error('[ERROR] Database passwords do not match. Please retry.');
            $this->databaseSetupPassword();
        }

        return $pass;
    }

    /**
     * Setup the user credentials.
     *
     * @return void
     */
    protected function userSetup()
    {
        $this->output->writeln(<<<STEP
<fg=yellow>
*-----------------------------------------------*
|                                               |
|            Configure Default User             |
|                                               |
*-----------------------------------------------*
</fg=yellow>
STEP
        );

        $first = $this->ask('Please enter the user first name');
        $last  = $this->ask('Please enter the user last name');
        $email = $this->ask('Please enter the user email');
        $pass  = $this->userSetupPassword();

        $headers = [
          'Setting',
          'Value'
        ];

        $data = [
          ['First Name', $first],
          ['Last Name', $last],
          ['Email', $email],
          ['Password', $pass],
        ];

        $this->table($headers, $data);

        if (!$this->confirm('Is the user information correct?')) {
            $this->userSetup();
        }

        $this->user = [
          'first' => $first,
          'last'  => $last,
          'email' => $email,
          'pass'  => $pass,
        ];

        $this->info('User configuration saved.');
    }

    /**
     * Setup the user credentials password.
     *
     * @return string
     */
    protected function userSetupPassword()
    {
        $pass        = $this->secret('Please enter the user password');
        $passConfirm = $this->secret('Please confirm the user password');

        if ($pass != $passConfirm) {
            $this->error('[ERROR] Passwords do not match.');
            $this->userSetupPassword();
        }

        return $pass;

    }

    /**
     * Setup ENV file with database credentials.
     *
     * @return void
     */
    protected function setupEnvFile()
    {
        $env    = __DIR__ . '/stubs/env.stub';
        $config = $this->database;

        // Update the env stub file with actual credentials.
        $contents = str_replace(
          array_map(function ($key) {
              return '{{' . $key . '}}';
          }, array_keys($config)),
          array_values($config),
          $this->laravel['files']->get($env)
        );

        // Generate a key
        $contents = str_replace('{{key}}', Str::random(32), $contents);

        // Check if we can actually write the environment file.
        if ($this->laravel['files']->put(($envFile = $this->laravel['path.base'] . '/.env'),
            $contents) === false
        ) {
            throw new \RuntimeException("Could not write env file to [$envFile].");
        }

        // Reload env file
        $this->laravel['Illuminate\Foundation\Bootstrap\DetectEnvironment']->bootstrap($this->laravel);

        // Reload config
        $this->laravel['Illuminate\Foundation\Bootstrap\LoadConfiguration']->bootstrap($this->laravel);

    }

    /**
     * Run vendor:publish to publish vendor assets.
     *
     * @return void
     */
    protected function triggerPublish()
    {
        $this->info('Starting publishing vendor assets.');
        $this->call('vendor:publish');
        $this->info('Publishing vendor assets finished.');

        // Reload config
        $this->laravel['Illuminate\Foundation\Bootstrap\LoadConfiguration']->bootstrap($this->laravel);
    }

    /**
     * Run the migrations to migrate the database.
     *
     * @return void.
     */
    protected function triggerMigrations()
    {
        $this->info('Starting database migrations.');
        $this->call('migrate');
        $this->info('Database migrations finished.');
    }

    /**
     * Create default Group and User
     *
     * @return void
     */
    protected function createDefaultUser()
    {
        // Get the user configuration data.
        $config = $this->user;

        // Create default permission.
        $this->permissionRepository->create([
          'name' => 'Administrator (Full Access)',
          'slug' => 'admin',
        ], false);

        // Create default role.
        $this->roleRepository->create([
          'name' => 'Registered',
          'slug' => 'registered',
        ], false);

        // Create the admin role.
        $role = $this->roleRepository->create([
          'name'        => 'Administrator',
          'slug'        => 'administrator',
          'permissions' => [
            'admin' => "1",
          ],
        ], false);

        // Create the user.
        $user = $this->authRepository->registerAndActivate([
          'email'      => array_get($config, 'email'),
          'first_name' => array_get($config, 'first'),
          'last_name'  => array_get($config, 'last'),
          'password'   => array_get($config, 'pass'),
          'role'       => 'administrator',
        ], false);

        // Attach user to admin role.
        $role->users()
             ->attach($user);
    }
}