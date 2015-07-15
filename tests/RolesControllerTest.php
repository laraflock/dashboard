<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RolesControllerTest extends TestCase
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
        $user = $this->authRepository->authenticate($userData);
        $this->authRepository->login($user);
    }

    public function testIndexRoute()
    {
        $response = $this->call('GET', '/dashboard/roles');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateRoute()
    {
        $response = $this->call('GET', '/dashboard/roles/create');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreate()
    {

    }

    public function testCreateFormValidationException()
    {

    }

    public function testCreateRolesException()
    {

    }

    public function testEditRoute()
    {
        $response = $this->call('GET', '/dashboard/roles/1/edit');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testEditRouteWrongId()
    {
        $this->call('GET', '/dashboard/roles/2/edit');

        $this->assertEquals('Role could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testDelete()
    {
        $this->call('DELETE', '/dashboard/roles/1/delete');

        $this->assertEquals('Role successfully deleted.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testDeleteWrongId()
    {
        $this->call('DELETE', '/dashboard/roles/2/delete');

        $this->assertEquals('Role could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }
}