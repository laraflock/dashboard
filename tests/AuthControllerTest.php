<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();
        $this->setupData();
    }

    protected function setupData()
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
    }

    public function testLoginRoute()
    {
        $this->visit('/auth/login')
             ->assertResponseOk();
    }

    public function testAuthentication()
    {
        $data = [
          'email'    => 'admin@change.me',
          'password' => 'test'
        ];

        $this->call('POST', '/auth/login', $data);

        $user = $this->authRepository->check();

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $user);
    }

    public function testAuthenticationFormValidationException()
    {
        $data = [
          'email'    => '',
          'password' => ''
        ];

        $this->call('POST', '/auth/login', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testAuthenticationAuthenticationException()
    {
        $data = [
          'email'    => 'admin@change.me',
          'password' => 'test2'
        ];

        $this->call('POST', '/auth/login', $data);

        $this->assertEquals('Email \ Password combination incorrect.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testRegisterRouteRedirect()
    {
        $this->visit('/auth/register')
             ->seePageIs('/auth/login');

        $this->assertEquals('Registration is not active. Please login.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testRegisterPostRedirect()
    {
        $this->call('POST', '/auth/register');

        $this->assertResponseStatus(302);
    }

    public function testRegisterRoute()
    {
        config(['laraflock.dashboard.registration' => true]);

        $this->visit('/auth/register')
             ->assertResponseOk();
    }

    public function testRegistration()
    {
        config(['laraflock.dashboard.registration' => true]);

        $data = [
          'email'                 => 'admin2@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
        ];

        $this->call('POST', '/auth/register', $data);

        $this->assertEquals('Account activated. Please login below.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testRegistrationFormValidationException()
    {
        config(['laraflock.dashboard.registration' => true]);

        $data = [
          'email'                 => '',
          'password'              => '',
          'password_confirmation' => '',
        ];

        $this->call('POST', '/auth/register', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testRegistrationRoleException()
    {
        config(['laraflock.dashboard.registration' => true]);
        config(['laraflock.dashboard.defaultRole' => 'fake']);

        $data = [
          'email'                 => 'admin2@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
        ];

        $this->call('POST', '/auth/register', $data);

        $this->assertEquals('Role could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testRegistrationWithActivation()
    {
        config(['laraflock.dashboard.registration' => true]);
        config(['laraflock.dashboard.activations' => true]);

        $data = [
          'email'                 => 'admin2@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
        ];

        $this->call('POST', '/auth/register', $data);

        $this->assertEquals('Account created. Activation needed, please check your email.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testActivateRouteRedirect()
    {
        $this->visit('/auth/activate')
             ->seePageIs('/auth/login');

        $this->assertEquals('Activations are not active. Please login.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testActivatePostRedirect()
    {
        $this->call('POST', '/auth/activate');

        $this->assertResponseStatus(302);
    }

    public function testActivateRoute()
    {
        config(['laraflock.dashboard.activations' => true]);

        $this->visit('/auth/register')
             ->assertResponseOk();
    }

    public function testActivateRouteWithParameters()
    {
        config(['laraflock.dashboard.activations' => true]);

        $this->visit('/auth/register?email=admin2@change.me&code=test')
             ->assertResponseOk();
    }

    public function testUserActivation()
    {
        config(['laraflock.dashboard.registration' => true]);
        config(['laraflock.dashboard.activations' => true]);

        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'registered',
        ];

        $activation = $this->authRepository->register($data, false);

        $activationData = [
          'email'           => $data['email'],
          'activation_code' => $activation->code,
        ];

        $this->call('POST', '/auth/activate', $activationData);

        $this->assertEquals('Account successfully activated.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testUserActivationFormValidationException()
    {
        config(['laraflock.dashboard.registration' => true]);
        config(['laraflock.dashboard.activations' => true]);

        $this->call('POST', '/auth/activate');

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testUserActivationAuthenticationExceptionActivationAlreadyCompleted()
    {
        config(['laraflock.dashboard.registration' => true]);
        config(['laraflock.dashboard.activations' => true]);

        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'registered',
        ];

        $activation = $this->authRepository->register($data, false);

        $activationData = [
          'email'           => $data['email'],
          'activation_code' => $activation->code,
        ];

        $this->call('POST', '/auth/activate', $activationData);

        $this->call('POST', '/auth/activate', $activationData);

        $this->assertEquals('Activation could not be completed.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testUserActivationAuthenticationExceptionWrongCode()
    {
        config(['laraflock.dashboard.registration' => true]);
        config(['laraflock.dashboard.activations' => true]);

        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'registered',
        ];

        $this->authRepository->register($data, false);

        $activationData = [
          'email'           => $data['email'],
          'activation_code' => '11',
        ];

        $this->call('POST', '/auth/activate', $activationData);

        $this->assertEquals('Activation could not be completed.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testLogout()
    {
        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $user = $this->authRepository->authenticate($userData);
        $this->authRepository->login($user);

        $this->visit('/auth/logout')
             ->assertResponseOk();
    }
}