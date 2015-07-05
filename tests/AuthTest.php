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
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Odotmedia\Dashboard\Services\Auth\AuthService;
use Odotmedia\Dashboard\Services\Role\RoleService;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * Test: View Login
     *
     * Description:
     * This will test that the user will be able to view the login page.
     *
     * @return void
     */
    public function testViewLogin()
    {
        $this->visit('/auth/login')
             ->assertResponseOk();
    }

    /**
     * Test: Email Validation
     *
     * Description:
     * This will test that the user has entered a valid email into the email field.
     *
     * @return void
     */
    public function testEmailValidation()
    {
        $this->visit('/auth/login')
             ->submitForm('Login', [
               'email'    => 'notemail',
               'password' => 'test'
             ])
             ->see('The email must be a valid email address.');
    }

    /**
     * Test: Required Fields
     *
     * Description:
     * This will test that the required fields of the login form have been filled out.
     *
     * @return void
     */
    public function testRequiredFields()
    {
        $this->visit('/auth/login')
             ->submitForm('Login')
             ->see('The email field is required.')
             ->see('The password field is required.');
    }

    /**
     * Test: Successful Auth
     *
     * Description:
     * This will test that a user who is registered and activated in the database has successfully logged in
     * and is taken to the Dashboard page.
     *
     * @return void
     */
    public function testSuccessAuth()
    {
        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $data = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $roleService = new RoleService();
        $roleService->create($roleData);

        $authService = new AuthService();
        $authService->registerAndActivate($data, false);

        $this->visit('/auth/login')
             ->submitForm('Login', $data)
             ->see('Dashboard');
    }

    /**
     * Test: Failed Auth
     *
     * Description:
     * This will test that a user who is registered and activated in the database has failed to log in
     * and is taken back to the login page and sees that error message.
     *
     * @return void
     */
    public function testFailAuth()
    {
        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $testData = [
          'email'    => 'admin@change.me',
          'password' => 'test1',
        ];

        $roleService = new RoleService();
        $roleService->create($roleData);

        $authService = new AuthService();
        $authService->registerAndActivate($userData, false);

        $this->visit('/auth/login')
             ->submitForm('Login', $testData)
             ->see('Email \ Password combination incorrect.');
    }

    /**
     * Test: Registration Not Active
     *
     * Description:
     * This will test that default config of registrations are not active.
     *
     * @return void
     */
    public function testRegistrationsNotActive()
    {
        $this->visit('/auth/register')
             ->see('Registration is not active. Please login.');
    }

    /**
     * Test: Registration Success
     *
     * Description:
     *
     * @return void
     */
    public function testRegistration()
    {

    }

    /**
     * Test: Registration Required Fields
     *
     * Description:
     *
     * @return void
     */
    public function testRegistrationRequiredFields()
    {

    }

    /**
     * Test: Registration Unique Emails
     *
     * Description:
     *
     * @return void
     */
    public function testRegistrationUniqueEmail()
    {

    }

    /**
     * Test: Activations Not Active
     *
     * Description:
     * This will test that default config of activations are not active.
     *
     * @return void
     */
    public function testActivationsNotActive()
    {
        $this->visit('/auth/activate')
             ->see('Activations are not active. Please login.');
    }

    /**
     * Test: Activation Success
     *
     * Description:
     *
     * @return void
     */
    public function testActivation()
    {

    }

    /**
     * Test: Activation Required Fields
     *
     * Description:
     *
     * @return void
     */
    public function testActivationRequiredFields()
    {

    }

    /**
     * Test: Activation Code Success
     *
     * Description:
     *
     * @return void
     */
    public function testActivationCodeSuccess()
    {

    }

    /**
     * Test: Activation Code Fail.
     *
     * Description:
     *
     * @return void
     */
    public function testActivationCodeFail()
    {

    }

    /**
     * Test: Logout
     *
     * Description:
     * This will test that a user who is registered and activated in the database has successfully logged in
     * and has now chosen to logout. This will log the user out and redirect them to the login page.
     *
     * @return void
     */
    public function testLogout()
    {
        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $roleService = new RoleService();
        $roleService->create($roleData);

        $authService = new AuthService();
        $authService->registerAndActivate($userData, false);

        $user = $authService->authenticate($userData);

        Sentinel::login($user);

        $this->visit('/auth/logout')
             ->see('Login');
    }
}