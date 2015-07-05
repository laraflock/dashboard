<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Odotmedia\Dashboard\Services\Permission\PermissionService;

class PermissionTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * Test: View Permissions Index Page
     *
     * Description:
     * This will test that you get a 200 status code when visiting the permissions index page.
     *
     * @return void
     */
    public function testViewPermissionsIndex()
    {
        $this->visit('/dashboard/permissions')
             ->assertResponseOk();
    }

    /**
     * Test: View Permissions Create Page
     *
     * Description:
     * This will test that you get a 200 status code when visiting the permissions create page.
     *
     * @return void
     */
    public function testViewPermissionsCreate()
    {
        $this->visit('/dashboard/permissions/create')
             ->assertResponseOk();
    }

    /**
     * Test: Permission Creation
     *
     * Description:
     * This will test the permission creation from the dashboard.
     *
     * @return void
     */
    public function testPermissionCreate()
    {
        $data = [
          'name' => 'Test',
          'slug' => 'test',
        ];

        $this->visit('/dashboard/permissions/create')
             ->submitForm('Save', $data)
             ->seeInDatabase('permissions', $data);
    }

    /**
     * Test: Permission Delete
     *
     * Description:
     * This will test the deletion of an existing permission via form found on index page of resource.
     *
     * @return void
     */
    public function testPermissionDelete()
    {
        $data = [
          'name' => 'Test',
          'slug' => 'test',
        ];

        $permissionService = new PermissionService();
        $permissionService->create($data, false);

        $this->visit('/dashboard/permissions')
             ->submitForm('Delete')
             ->see('Permission successfully deleted.');
    }

    /**
     * Test: Required Fields Create
     *
     * Description:
     * This will test the required fields of the create permission form have been filled out.
     *
     * @return void
     */
    public function testRequiredFieldsCreate()
    {
        $this->visit('/dashboard/permissions/create')
             ->submitForm('Save')
             ->see('The name field is required.')
             ->see('The slug field is required.');
    }

    /**
     * Test: View Permissions Edit Page
     *
     * Description:
     * This will test that you get a 200 status code when visiting the permissions edit page.
     *
     * @return void
     */
    public function testViewPermissionEdit()
    {
        $data = [
          'name' => 'Test',
          'slug' => 'test',
        ];

        $permissionService = new PermissionService();
        $permissionService->create($data, false);

        $this->visit('/dashboard/permissions/1/edit')
             ->assertResponseOk();
    }

    /**
     * Test: Permission Edit
     *
     * Description:
     * This will test that you see the updated information in the database after editing the permission.
     *
     * @return void
     */
    public function testPermissionEdit()
    {
        $data = [
          'name' => 'Test',
          'slug' => 'test',
        ];

        $data2 = [
          'name' => 'Test2',
          'slug' => 'test2',
        ];

        $permissionService = new PermissionService();
        $permissionService->create($data, false);

        $this->visit('/dashboard/permissions/1/edit')
             ->submitForm('Save', $data2)
             ->seeInDatabase('permissions', $data2);
    }

    /**
     * Test: Required Fields Edit
     *
     * Description:
     * This will test the required fields of the edit permission form have been filled out.
     *
     * @return void
     */
    public function testRequiredFieldsEdit()
    {
        $data = [
          'name' => 'Test',
          'slug' => 'test',
        ];

        $data2 = [
          'name' => '',
          'slug' => '',
        ];

        $permissionService = new PermissionService();
        $permissionService->create($data, false);

        $this->visit('/dashboard/permissions/1/edit')
             ->submitForm('Save', $data2)
             ->see('The name field is required.')
             ->see('The slug field is required.');
    }

    /**
     * Test: Unique Slug Create
     *
     * Description:
     * This will test that there is already a permissions with either the name or slug, and
     * does proper error handling.
     *
     * @return void
     */
    public function testUniqueSlugCreate()
    {
        $data = [
          'name' => 'Test',
          'slug' => 'test',
        ];

        $permissionService = new PermissionService();
        $permissionService->create($data, false);

        $this->visit('/dashboard/permissions/create')
             ->submitForm('Save', [
               'name' => 'Test1',
               'slug' => 'test',
             ])
             ->see('The slug has already been taken.');
    }

    /**
     * Test: Unique Slug Edit
     *
     * Description:
     * This will test that there is already a permission with the slug, and does proper error handling.
     *
     * @return void
     */
    public function testUniqueSlugEdit()
    {
        $data = [
          'name' => 'Test',
          'slug' => 'test',
        ];

        $data2 = [
          'name' => 'Test1',
          'slug' => 'test1',
        ];

        $permissionService = new PermissionService();
        $permissionService->create($data, false);
        $permissionService->create($data2, false);

        $this->visit('/dashboard/permissions/2/edit')
             ->submitForm('Save', [
               'name' => 'Test1',
               'slug' => 'test',
             ])
             ->see('The slug has already been taken.');
    }
}