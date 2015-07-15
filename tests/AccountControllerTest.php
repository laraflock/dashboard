<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AccountControllerTest extends TestCase
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

        $userData2 = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
        ];

        $this->roleRepository->create($roleData);
        $this->authRepository->registerAndActivate($userData, false);
        $this->authRepository->registerAndActivate($userData2, false);
        $user = $this->authRepository->authenticate($userData);
        $this->authRepository->login($user);
    }

    public function testAccountEditRoute()
    {
        $this->visit('/dashboard/account')
             ->assertResponseOk();
    }

    public function testUpdateAccount()
    {
        $data = [
          'action' => 'update_account',
          'email'  => 'admin3@change.me',
        ];

        $this->call('POST', '/dashboard/account/1', $data);

        $this->assertEquals('Account successfully updated.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testUpdateAccountFormValidationException()
    {
        $data = [
          'action' => 'update_account',
          'email'  => 'admin2@change.me',
        ];

        $this->call('POST', '/dashboard/account/1', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testUpdateAccountUserException()
    {
        $data = [
          'action' => 'update_account',
        ];

        $this->call('POST', '/dashboard/account/3', $data);

        $this->assertEquals('User could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testUpdatePassword()
    {
        $data = [
          'action'                    => 'change_password',
          'email'                     => 'admin@change.me',
          'password'                  => 'test',
          'new_password'              => 'test1',
          'new_password_confirmation' => 'test1',
        ];

        $this->call('POST', '/dashboard/account/1', $data);

        $this->assertEquals('Password successfully updated.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testUpdatePasswordFormValidationException()
    {
        $data = [
          'action'                    => 'change_password',
          'email'                     => 'admin@change.me',
          'password'                  => 'test',
          'new_password'              => 'test2',
          'new_password_confirmation' => 'test1',
        ];

        $this->call('POST', '/dashboard/account/1', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testUpdatePasswordAuthenticationException()
    {
        $data = [
          'action'                    => 'change_password',
          'email'                     => 'admin@change.me',
          'password'                  => 'test2',
          'new_password'              => 'test1',
          'new_password_confirmation' => 'test1',
        ];

        $this->call('POST', '/dashboard/account/1', $data);

        $this->assertEquals('Old password is incorrect.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }
}