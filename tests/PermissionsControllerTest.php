<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PermissionsControllerTest extends TestCase
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

        $permissionData = [
          'name' => 'Test',
          'slug' => 'test',
        ];

        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $this->roleRepository->create($roleData);
        $this->permissionRepository->create($permissionData);
        $this->authRepository->registerAndActivate($userData, false);
        $user = $this->authRepository->authenticate($userData);
        $this->authRepository->login($user);
    }

    public function testIndexRoute()
    {
        $response = $this->call('GET', '/dashboard/permissions');

        $this->assertEquals(200, $response->getStatusCode());

    }

    public function testCreateRoute()
    {
        $response = $this->call('GET', '/dashboard/permissions/create');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreate()
    {
        $data = [
          'name' => 'Create Users',
          'slug' => 'users.create',
        ];

        $this->call('POST', '/dashboard/permissions', $data);

        $this->assertEquals('Permission successfully created.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testCreateFormValidationException()
    {
        $data = [
          'name' => '',
          'slug' => '',
        ];

        $this->call('POST', '/dashboard/permissions', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testEditRoute()
    {
        $response = $this->call('GET', '/dashboard/permissions/1/edit');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testEditRouteWrongId()
    {
        $this->call('GET', '/dashboard/permissions/2/edit');

        $this->assertEquals('Permission could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testEdit()
    {
        $data = [
          'name' => 'Test2',
          'slug' => 'test2',
        ];

        $this->call('POST', '/dashboard/permissions/1/edit', $data);

        $this->assertEquals('Permission successfully updated.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testEditFromValidationException()
    {
        $data = [
          'name' => 'Test 2',
          'slug' => 'test 2',
        ];

        $this->call('POST', '/dashboard/permissions/1/edit', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testEditPermissionsException()
    {
        $data = [
          'name' => 'Test2',
          'slug' => 'test2',
        ];

        $this->call('POST', '/dashboard/permissions/2/edit', $data);

        $this->assertEquals('Permission could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testDelete()
    {
        $this->call('DELETE', '/dashboard/permissions/1/delete');

        $this->assertEquals('Permission successfully deleted.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testDeleteRouteWrongId()
    {
        $this->call('DELETE', '/dashboard/permissions/2/delete');

        $this->assertEquals('Permission could not be found.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }
}