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
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Odotmedia\Dashboard\Services\Auth\AuthService;
use Odotmedia\Dashboard\Services\Role\RoleService;
use Odotmedia\Dashboard\Services\User\UserService;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * Test: View Users Index Page
     *
     * Description:
     * This will test you get a 200 status code when visiting the users index page.
     *
     * @return void
     */
    public function testViewUsersIndex()
    {
        $this->visit('/dashboard/users')
             ->assertResponseOk();
    }

    /**
     * Test: View Users Create Page
     *
     * Description:
     * This will test that you get a 200 status code when visiting the users create page.
     *
     * @return void
     */
    public function testViewUsersCreate()
    {
        $this->visit('/dashboard/users/create')
             ->assertResponseOk();
    }

    /**
     * Test: User Create
     *
     * Description:
     * This will test the user creation from the dashboard.
     *
     * @return void
     */
    public function testUserCreate()
    {
        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
          'first_name'            => 'Test First',
          'last_name'             => 'Test Last',
        ];

        $testData = [
          'email' => 'admin@change.me',
        ];

        $roleService = new RoleService();
        $roleService->create($roleData);

        $this->visit('/dashboard/users/create')
             ->submitForm('Save', $userData)
             ->seeInDatabase('users', $testData);
    }

    /**
     * Test: Required Fields Create
     *
     * Description:
     * This will test the required fields of the create user form have been filled out.
     *
     * @return void
     */
    public function testRequiredFieldsCreate()
    {
        $this->visit('/dashboard/users/create')
             ->submitForm('Save')
             ->see('The email field is required.')
             ->see('The password field is required.')
             ->see('The password confirmation field is required.');
    }

    /**
     * Test: Unique User Emails
     *
     * Description:
     * This will test the creation form against a user with the same email address that
     * already exists in the database.
     *
     * @return void
     */
    public function testUniqueEmailCreate()
    {
        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
          'first_name'            => 'Test First',
          'last_name'             => 'Test Last',
        ];

        $testData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
          'first_name'            => 'Test First',
          'last_name'             => 'Test Last',
        ];

        $roleService = new RoleService();
        $roleService->create($roleData);

        $userService = new UserService();
        $userService->create($userData);

        $this->visit('/dashboard/users/create')
             ->submitForm('Save', $testData)
             ->see('The email has already been taken.');
    }

    /**
     * Test: View Users Edit Page
     *
     * Description:
     * This will test that you get a 200 status code when visiting the users edit page.
     *
     * @return void
     */
    public function testViewUserEdit()
    {
        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
          'first_name'            => 'Test First',
          'last_name'             => 'Test Last',
        ];

        $roleService = new RoleService();
        $roleService->create($roleData);

        $userService = new UserService();
        $userService->create($userData);

        $this->visit('/dashboard/users/1/edit')
             ->assertResponseOk();
    }

    /**
     * Test: Required Fields
     *
     * Description:
     * This will test the required fields of the edit user form have been filled out.
     *
     * @return void
     */
    public function testRequiredFieldsEdit()
    {
        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
          'first_name'            => 'Test First',
          'last_name'             => 'Test Last',
        ];

        $testData = [
          'email' => '',
        ];

        $roleService = new RoleService();
        $roleService->create($roleData);

        $userService = new UserService();
        $userService->create($userData);

        $this->visit('/dashboard/users/1/edit')
             ->submitForm('Save', $testData)
             ->see('The email field is required.');
    }

    /**
     * Test: User Edit
     *
     * Description:
     *
     * @throws \Odotmedia\Dashboard\Exceptions\RolesException
     */
    public function testUserEdit()
    {
        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
          'first_name'            => 'Test First',
          'last_name'             => 'Test Last',
        ];

        $testData = [
          'email'      => 'admin@change.me',
          'first_name' => 'Test First Update',
          'last_name'  => 'Test Last Update',
        ];

        $roleService = new RoleService();
        $roleService->create($roleData);

        $userService = new UserService();
        $userService->create($userData);

        $this->visit('/dashboard/users/1/edit')
             ->submitForm('Save', $testData)
             ->see('User successfully updated.')
             ->seeInDatabase('users', $testData);
    }

    /**
     * Test: User Edit Unique Email
     *
     * Description:
     * This will test if you are editing a current user, and try to update the user's email address to
     * an email address that already exists for another user. It will test that proper error handling
     * message is displaying.
     *
     * @return void
     */
    public function testUniqueEmailEdit()
    {
        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
          'first_name'            => 'Test First',
          'last_name'             => 'Test Last',
        ];

        $userData2 = [
          'email'                 => 'admin2@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
          'first_name'            => 'Test First',
          'last_name'             => 'Test Last',
        ];

        $testData = [
          'email'      => 'admin2@change.me',
          'first_name' => 'Test First Update',
          'last_name'  => 'Test Last Update',
        ];

        $roleService = new RoleService();
        $roleService->create($roleData);

        $userService = new UserService();
        $userService->create($userData);
        $userService->create($userData2);

        $this->visit('/dashboard/users/1/edit')
             ->submitForm('Save', $testData)
             ->see('The email has already been taken.');
    }
}