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
use Illuminate\Foundation\Testing\WithoutMiddleware;

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
     * Test: Login Required Fields
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

        $this->roleRepository->create($roleData);

        $this->authRepository->registerAndActivate($data, false);

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

        $this->roleRepository->create($roleData);

        $this->authRepository->registerAndActivate($userData, false);

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
     * Test: Registration Active
     *
     * Description:
     * This will test that the user overwrite the config and registrations are active.
     *
     * @return void
     */
    public function testRegistrationActive()
    {
        config(['odotmedia.dashboard.registration' => true]);

        $this->visit('/auth/register')
             ->assertResponseOk();
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
        config(['odotmedia.dashboard.registration' => true]);

        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
        ];

        $testData = [
          'email' => 'admin@change.me',
        ];

        $this->roleRepository->create($roleData, false);

        $this->visit('/auth/register')
             ->submitForm('Register', $userData)
             ->seeInDatabase('users', $testData);
    }

    /**
     * Test: Registration Required Fields
     *
     * Description:
     * This will test that the required fields of the registration form have been filled out.
     *
     * @return void
     */
    public function testRegistrationRequiredFields()
    {
        config(['odotmedia.dashboard.registration' => true]);

        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $this->roleRepository->create($roleData, false);

        $this->visit('/auth/register')
             ->submitForm('Register')
             ->see('The email field is required.')
             ->see('The password field is required.')
             ->see('The password confirmation field is required.');
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
        config(['odotmedia.dashboard.registration' => true]);

        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
        ];

        $this->roleRepository->create($roleData, false);

        $this->authRepository->register($userData, false);

        $this->visit('/auth/register')
             ->submitForm('Register', $userData)
             ->see('The email has already been taken.');
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
     * Test: Activations Active
     *
     * Description:
     * This will test that the user overwrite the config and activations are active.
     *
     * @return void
     */
    public function testActivationActive()
    {
        config(['odotmedia.dashboard.activations' => true]);

        $this->visit('/auth/activate')
             ->see('Activate Account');
    }

    /**
     * Test: Activation Required Fields
     *
     * Description:
     * This will test that the required fields of the activation form have been filled out.
     *
     * @return void
     */
    public function testActivationRequiredFields()
    {
        config(['odotmedia.dashboard.activations' => true]);

        $this->visit('/auth/activate')
             ->submitForm('Activate')
             ->see('The email field is required.')
             ->see('The activation code field is required.');
    }

    /**
     * Test: Activation Code Success
     *
     * Description:
     * This will test that a user was successfully activated after input of their email and activation code.
     *
     * @return void
     */
    public function testActivationCodeSuccess()
    {
        config(['odotmedia.dashboard.activations' => true]);

        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
        ];

        $this->roleRepository->create($roleData, false);

        $activation = $this->authRepository->register($userData, false);

        $testData = [
          'email'           => $userData['email'],
          'activation_code' => $activation->code,
        ];

        $this->visit('/auth/activate')
             ->submitForm('Activate', $testData)
             ->seeInDatabase('activations', [
               'user_id'   => 1,
               'code'      => $activation->code,
               'completed' => true,
             ])
             ->see('Account successfully activated.');
    }

    /**
     * Test: Activation Code Fail.
     *
     * Description:
     * This will test a failed activation of a user who input their email but the wrong activation code.
     *
     * @return void
     */
    public function testActivationCodeFail()
    {
        config(['odotmedia.dashboard.activations' => true]);

        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $userData = [
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
        ];

        $this->roleRepository->create($roleData, false);

        $this->authRepository->register($userData, false);

        $testData = [
          'email'           => $userData['email'],
          'activation_code' => 'wrongActivationCode',
        ];

        $this->visit('/auth/activate')
             ->submitForm('Activate', $testData)
             ->see('Activation could not be completed.');
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

        $this->roleRepository->create($roleData);

        $this->authRepository->registerAndActivate($userData, false);

        $user = $this->authRepository->authenticate($userData);

        $this->authRepository->login($user);

        $this->visit('/auth/logout')
             ->see('Login');
    }
}