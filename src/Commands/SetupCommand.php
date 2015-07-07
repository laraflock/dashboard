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

class SetupCommand extends InstallerCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up the default user, roles and migrations.';

    /**
     * The default user to setup.
     *
     * @var array
     */
    protected $user = array();

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $this->userSetup();
        $this->triggerPublish();
        $this->call('dashboard:fresh');
        $this->triggerMigrations();
        $this->createDefaultUser();
        $this->info('Setup is complete. Keep coding!');
    }
}