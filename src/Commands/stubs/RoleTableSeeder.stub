<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

use Illuminate\Database\Seeder;
use Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface as Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Role interface.
     *
     * @var Role
     */
    protected $role;

    /**
     * The constructor.
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultRole = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $adminRole = [
          'name'        => 'Administrator',
          'slug'        => 'administrator',
          'permissions' => [
            'admin' => "1",
          ],
        ];

        $this->role->create($defaultRole, false);
        $this->role->create($adminRole, false);
    }
}