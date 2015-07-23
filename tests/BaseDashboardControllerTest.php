<?php

class BaseDashboardControllerTest extends TestCase
{
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

        $roleData2 = [
          'name' => 'Administrator',
          'slug' => 'administrator',
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
        $this->roleRepository->create($roleData2);
        $this->authRepository->registerAndActivate($userData, false);
        config(['laraflock.dashboard.defaultRole' => 'administrator']);
        $this->authRepository->registerAndActivate($userData2, false);
    }

    public function testDashboardNotLoggedIn()
    {
        $this->visit('/dashboard')
             ->seePageIs('/auth/login');

        $this->assertEquals('Access Denied', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }

    public function testDashboardRouteNotInRole()
    {
        $data = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $this->visit('/auth/login')
             ->submitForm('Login', $data)
             ->see('Access Denied');

        $this->assertEquals('Access Denied', session('flash_notification.message'));
        $this->assertEquals('danger', session('flash_notification.level'));
    }
}