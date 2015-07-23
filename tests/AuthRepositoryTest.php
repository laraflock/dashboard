<?php

/**
 * @package     Dashboard
 * @version     3.0.0
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

class AuthRepositoryTest extends TestCase
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

        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $this->roleRepository->create($roleData);
        $this->authRepository->registerAndActivate($userData, false);
    }

    public function testGetActiveUser()
    {
        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $user = $this->authRepository->authenticate($userData);
        $this->authRepository->login($user);
        $activeUser = $this->authRepository->getActiveUser();

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $activeUser);
    }

    public function testCheckTrue()
    {
        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $user = $this->authRepository->authenticate($userData);
        $this->authRepository->login($user);
        $check = $this->authRepository->check();

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $check);
    }

    public function testCheckFalse()
    {
        $this->assertFalse($this->authRepository->check());
    }

    public function testAuthenticate()
    {
        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $user = $this->authRepository->authenticate($userData);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $user);
    }

    public function testAuthenticateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $userData = [
          'email'    => 'admin',
          'password' => 'test',
        ];

        $this->authRepository->authenticate($userData);
    }

    public function testAuthenticateAuthenticationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\AuthenticationException');

        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test2',
        ];

        $this->authRepository->authenticate($userData);
    }

    public function testRegister()
    {
        config(['laraflock.dashboard.activations' => true]);

        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'registered',
        ];

        $activation = $this->authRepository->register($data, false);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Activations\EloquentActivation::class, $activation);
    }

    public function testRegisterAuthenticationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\AuthenticationException');

        $data = [
          'email'    => 'admin@change.me',
          'password' => 'test',
          'role'     => 'registered',
        ];

        $this->authRepository->register($data, false);
    }

    public function testRegisterRolesException()
    {
        config(['laraflock.dashboard.activations' => true]);

        $this->setExpectedException('Laraflock\Dashboard\Exceptions\RolesException');

        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'administrator',
        ];

        $this->authRepository->register($data, false);
    }

    public function testRegisterAndActivate()
    {
        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'registered',
        ];

        $user = $this->authRepository->register($data, false);

        $this->assertTrue($user);
    }

    public function testRegisterAndActivateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $data = [
          'email'    => 'admin',
          'password' => 'test',
          'role'     => 'registered',
        ];

        $this->authRepository->registerAndActivate($data, true);
    }

    public function testRegisterAndActivateAuthenticationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\AuthenticationException');

        $data = [
          'email'    => 'admin@change.me',
          'password' => 'test',
          'role'     => 'registered',
        ];

        $this->authRepository->registerAndActivate($data, false);
    }

    public function testRegisterAndActivateRolesException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\RolesException');

        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'administrator',
        ];

        $this->authRepository->registerAndActivate($data, false);
    }

    public function testActivate()
    {
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

        $activated = $this->authRepository->activate($activationData, false);

        $this->assertTrue($activated);
    }

    public function testActivateAuthenticationException()
    {
        config(['laraflock.dashboard.activations' => true]);

        $this->setExpectedException('Laraflock\Dashboard\Exceptions\AuthenticationException');

        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'registered',
        ];

        $this->authRepository->register($data, false);

        $activationData = [
          'email'           => $data['email'],
          'activation_code' => 'notthecode',
        ];

        $this->authRepository->activate($activationData, false);
    }

    public function testFindUserByCredentials()
    {
        $user = $this->authRepository->findByCredentials(['login' => 'admin@change.me']);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $user);
    }

    public function login()
    {
        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $user      = $this->authRepository->authenticate($userData);
        $loginUser = $this->authRepository->login($user);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $loginUser);
    }

    public function logout()
    {
        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test',
        ];

        $user = $this->authRepository->authenticate($userData);
        dd($this->authRepository->logout($user));
    }
}