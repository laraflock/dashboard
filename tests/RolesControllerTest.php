<?php

/**
 * @package     Dashboard
 * @version     3.0.0
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

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
        $data = [
            'name' => 'Administrator',
            'slug' => 'administrator',
        ];

        $this->call('POST', '/dashboard/roles', $data);

        $this->assertEquals('Role successfully created.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testCreateFormValidationException()
    {
        $data = [
            'name' => 'Registered',
            'slug' => 'registered',
        ];

        $this->call('POST', '/dashboard/roles', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
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

    public function testEdit()
    {
        $data = [
          'name' => 'Registered2',
          'slug' => 'registered',
        ];

        $this->call('POST', '/dashboard/roles/1/edit', $data);

        $this->assertEquals('Role successfully updated.', session('flash_notification.message'));
        $this->assertEquals('success', session('flash_notification.level'));
    }

    public function testEditFormValidationException()
    {
        $data = [
          'name' => 'Registered 2',
          'slug' => 'registered 2',
        ];

        $this->call('POST', '/dashboard/roles/1/edit', $data);

        $this->assertEquals('Fix errors in the form below.', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testEditRolesException()
    {
        $data = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $this->call('POST', '/dashboard/roles/2/edit', $data);

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