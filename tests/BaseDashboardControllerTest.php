<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

use Illuminate\Support\Facades\Session;

class BaseDashboardControllerTest extends TestCase
{
    protected $adminRole;

    public function setUp()
    {
        parent::setUp();
        $this->setupData();
    }

    protected function setupData()
    {
        // Added Session Start to properly test CSRF Token
        Session::start();

        $roleData = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $roleData2 = [
          'name'        => 'Administrator',
          'slug'        => 'administrator',
          'permissions' => [
            'admin' => "1",
          ],
        ];

        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $this->roleRepository->create($roleData);
        $this->adminRole = $this->roleRepository->create($roleData2);
        $this->authRepository->registerAndActivate($userData, false);
    }

    public function testDashboardNotLoggedIn()
    {
        $this->call('GET', '/dashboard');

        $this->assertEquals('Access Denied', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testDashboardRouteNotInRole()
    {
        $data = [
          'email'    => 'admin@change.me',
          'password' => 'test',
          '_token'   => csrf_token(),
        ];

        $this->call('POST', '/auth/login', $data);

        $user = $this->authRepository->check();

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $user);

        $this->call('GET', '/dashboard');

        $this->assertEquals('Access Denied', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }
}