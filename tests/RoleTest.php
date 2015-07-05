<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Odotmedia\Dashboard\Services\Role\RoleService;

class RoleTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * Test: View Roles Index Page
     *
     * Description:
     * This will test you get a 200 status when visiting the roles index page.
     *
     * @return void
     */
    public function testViewRolesIndex()
    {
        $this->visit('/dashboard/roles')
             ->assertResponseOk();
    }

    /**
     * Test: View Roles Create Page
     *
     * Description:
     * This will test that you get a 200 status when visiting the roles create page.
     *
     * @return void
     */
    public function testViewRolesCreate()
    {
        $this->visit('/dashboard/roles/create')
             ->assertResponseOk();
    }

    /**
     * Test: Role Create
     *
     * Description:
     * This will test the role creation from the dashboard.
     *
     * @return void
     */
    public function testRoleCreate()
    {
        $data = [
            'slug' => 'testrole',
            'name' => 'Test',
        ];

        $this->visit('/dashboard/roles/create')
             ->submitForm('Save', $data)
             ->seeInDatabase('roles', $data);
    }

    /**
     * Test: Role Delete
     *
     * Description:
     * This will test the deletion of an existing role via form found on index page of resource.
     *
     * @return void
     */
    public function testRoleDelete()
    {
        $data = [
          'name' => 'Test',
          'slug' => 'test',
        ];

        $roleService = new RoleService();
        $roleService->create($data, false);

        $this->visit('/dashboard/roles')
             ->submitForm('Delete')
             ->see('Role successfully deleted.');
    }

    /**
     * Test: View Roles Edit Page
     *
     * Description:
     * This will test that you get a 200 status when visiting the roles edit page.
     *
     * @return void
     */
    public function testViewRolesEdit()
    {
        $data = [
          'slug' => 'testrole',
          'name' => 'Test',
        ];

        $roleService = new RoleService();
        $roleService->create($data, false);

        $this->visit('/dashboard/roles/1/edit')
             ->assertResponseOk();
    }

    /**
     * Test: Role Edit
     *
     * Description:
     * This will test the role edit name from the dashboard.
     *
     * @return void
     */
    public function testRoleEdit()
    {
        $data = [
          'slug' => 'testrole',
          'name' => 'Test',
        ];

        $testData = [
            'name' => 'Updated',
            'slug' => 'testrole',
        ];

        $roleService = new RoleService();
        $roleService->create($data, false);

        $this->visit('/dashboard/roles/1/edit')
             ->submitForm('Save', $testData)
             ->seeInDatabase('roles', $testData);
    }

    /**
     * Test: Role Edit Slug
     *
     * Description:
     * This will test the role edit slug from the dashboard.
     *
     * @return void
     */
    public function testRoleEditSlug()
    {
        $data = [
            'slug' => 'testrole',
            'name' => 'Test',
        ];

        $testData = [
            'name' => 'Test',
            'slug' => 'testrole2',
        ];

        $roleService = new RoleService();
        $roleService->create($data, false);

        $this->visit('/dashboard/roles/1/edit')
             ->submitForm('Save', $testData)
             ->seeInDatabase('roles', $testData);
    }
}