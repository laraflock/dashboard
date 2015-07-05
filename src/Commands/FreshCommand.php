<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Console\Input\InputOption;

class FreshCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove auth included with the framework';

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

        $files = new Filesystem;

        $files->deleteDirectory(app_path('Http/Controllers/Auth'));

        $files->delete(base_path('database/migrations/2014_10_12_000000_create_users_table.php'));
        $files->delete(base_path('database/migrations/2014_10_12_100000_create_password_resets_table.php'));

        $this->info('Original Auth removed! Enjoy your fresh start.');
    }
}