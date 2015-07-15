<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UsersControllerTest extends TestCase
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
          'email'                 => 'admin@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
        ];

        $this->roleRepository->create($roleData);
        $this->userRepository->create($userData, false);
    }

    public function testIndexRoute()
    {
        $response = $this->call('GET', '/dashboard/users');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateRoute()
    {
        $response = $this->call('GET', '/dashboard/users/create');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreate()
    {
        $data = [
          'email'                 => 'admin2@change.me',
          'password'              => 'test',
          'password_confirmation' => 'test',
        ];

        $this->call('POST', '/dashboard/users', $data);

        $this->assertEquals('User successfully created.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testCreateFormValidationException()
    {
        $data = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $this->call('POST', '/dashboard/users', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testEditRoute()
    {
        $response = $this->call('GET', '/dashboard/users/1/edit');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testEditRouteWrongId()
    {
        $this->call('GET', '/dashboard/users/2/edit');

        $this->assertEquals('User could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testEdit()
    {
        $data = [
          'first_name' => 'Admin',
          'last_name'  => 'Updated',
          'email'      => 'admin@change.me',
        ];

        $this->call('POST', '/dashboard/users/1/edit', $data);

        $this->assertEquals('User successfully updated.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testEditFormValidationException()
    {
        $data = [
          'first_name' => 'Admin',
          'last_name'  => 'ChangeMe',
          'email'      => 'notemail',
        ];

        $this->call('POST', '/dashboard/users/1/edit', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testEditUsersException()
    {
        $data = [
          'first_name' => 'Admin',
          'last_name'  => 'Updated',
          'email'      => 'admin@change.me',
        ];

        $this->call('POST', '/dashboard/users/2/edit', $data);

        $this->assertEquals('User could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testDelete()
    {
        $this->call('DELETE', '/dashboard/users/1/delete');

        $this->assertEquals('User successfully deleted.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testDeleteRouteWrongId()
    {
        $this->call('DELETE', '/dashboard/users/2/delete');

        $this->assertEquals('User could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }
}