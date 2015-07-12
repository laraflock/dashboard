<?php

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
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\FormValidationException');

        $userData = [
          'email'    => 'admin',
          'password' => 'test',
        ];

        $this->authRepository->authenticate($userData);
    }

    public function testAuthenticateAuthenticationException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\AuthenticationException');

        $userData = [
          'email'    => 'admin@change.me',
          'password' => 'test2',
        ];

        $this->authRepository->authenticate($userData);
    }

    public function testRegister()
    {
        //
    }

    public function testRegisterAuthenticationException()
    {
        //
    }

    public function testRegisterRolesException()
    {
        config(['odotmedia.dashboard.activations' => true]);

        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\RolesException');

        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'administrator',
        ];

        $this->authRepository->register($data, false);
    }

    public function testRegisterAndActivate()
    {
        //
    }

    public function testRegisterAndActivateFormValidationException()
    {
        //
    }

    public function testRegisterAndActivateAuthenticationException()
    {
        //
    }

    public function testRegisterAndActivateRolesException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\RolesException');

        $data = [
          'email'    => 'admin2@change.me',
          'password' => 'test',
          'role'     => 'administrator',
        ];

        $this->authRepository->registerAndActivate($data, false);
    }

    public function testActivate()
    {
        //
    }

    public function testActivateAuthenticationException()
    {
        //
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