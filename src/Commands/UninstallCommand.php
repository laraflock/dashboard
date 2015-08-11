<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Console\Input\InputOption;

class UninstallCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove dashboard files, rollback migrations.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        // Reset all database migrations.
        $this->call('migrate:reset');

        // Setup Filesystem instance.
        $files = new Filesystem;

        // Delete published assets from Laravel.
        $files->deleteDirectory(base_path('public/vendor/laraflock'));

        // Delete published views from Laravel.
        $files->deleteDirectory(base_path('resources/views/vendor/dashboard'));

        // Delete published config from Laravel.
        $files->delete(base_path('config/cartalyst.sentinel.php'));
        $files->delete(base_path('config/laraflock.dashboard.php'));

        // Delete database migrations.
        $files->delete(base_path('database/migrations/2014_07_02_230147_migration_cartalyst_sentinel.php'));
        $files->delete(base_path('database/migrations/2015_06_26_031155_create_permissions_table.php'));

        $this->info('Uninstall is successfull.');
    }
}