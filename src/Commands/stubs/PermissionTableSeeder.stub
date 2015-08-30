<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

use Illuminate\Database\Seeder;
use Laraflock\Dashboard\Repositories\Permission\PermissionRepositoryInterface as Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Permission interface.
     *
     * @var Permission
     */
    protected $permission;

    /**
     * The constructor.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultPermission = [
          'name' => 'Administrator (Full Access)',
          'slug' => 'admin',
        ];

        $this->permission->create($defaultPermission, false);
    }
}