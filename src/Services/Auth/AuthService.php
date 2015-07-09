<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Services\Auth;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Validator;
use Odotmedia\Dashboard\Exceptions\AuthenticationException;
use Odotmedia\Dashboard\Exceptions\FormValidationException;
use Odotmedia\Dashboard\Exceptions\RolesException;
use Odotmedia\Dashboard\Services\Base\BaseService;

class AuthService extends BaseService
{
    /**
     * Get active user.
     *
     * @return mixed
     */
    public function getActiveUser()
    {
        return Sentinel::getUser();
    }

    /**
     * Check if user is logged in.
     *
     * @return mixed
     */
    public function check()
    {
        return Sentinel::check();
    }

    /**
     * Authenticate the user.
     *
     * @param array $data
     *
     * @throws AuthenticationException
     * @throws FormValidationException
     */
    public function authenticate(array $data)
    {
        $this->rules = [
          'email'    => 'required|email',
          'password' => 'required',
        ];

        $remember = false;

        if (isset($data['remember'])) {
            $remember = $data['remember'];
        }

        $this->validate($data);

        if (!$user = Sentinel::authenticate($data, $remember)) {
            throw new AuthenticationException('Email \ Password combination incorrect.');
        }

        return $user;
    }

    /**
     * Register a user.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @return bool
     *
     * @throws \Odotmedia\Dashboard\Exceptions\AuthenticationException
     * @throws \Odotmedia\Dashboard\Exceptions\FormValidationException
     * @throws \Odotmedia\Dashboard\Exceptions\RolesException
     */
    public function register(array $data, $validate = true)
    {
        $this->rules = [
          'email'                 => 'required|unique:users',
          'password'              => 'required|confirmed',
          'password_confirmation' => 'required',
        ];

        if ($validate) {
            $this->validate($data);
        }

        if (!config('odotmedia.dashboard.activations')) {
            $this->registerAndActivate($data);

            return true;
        }

        if (!$user = Sentinel::register($data)) {
            throw new AuthenticationException('User could not be created.');
        }

        if (!$activation = Activation::create($user)) {
            throw new AuthenticationException('Activation could not be created.');
        }

        return $activation;
    }

    /**
     * Register and activate user if activations are false.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @throws \Odotmedia\Dashboard\Exceptions\AuthenticationException
     * @throws \Odotmedia\Dashboard\Exceptions\FormValidationException
     * @throws \Odotmedia\Dashboard\Exceptions\RolesException
     */
    public function registerAndActivate(array $data, $validate = true)
    {
        $this->rules = [
          'email'                 => 'required|unique:users',
          'password'              => 'required|confirmed',
          'password_confirmation' => 'required',
        ];

        if ($validate) {
            $this->validate($data);
        }

        if (!$user = Sentinel::registerAndActivate($data)) {
            throw new AuthenticationException('User could not be created.');
        }

        if (!isset($data['role'])) {
            $data['role'] = config('odotmedia.dashboard.defaultRole');
        }

        if (!$role = Sentinel::findRoleBySlug($data['role'])) {
            throw new RolesException('Role could not be found.');
        }

        $role->users()
             ->attach($user);

        return;
    }

    /**
     * Activate a user.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @throws \Odotmedia\Dashboard\Exceptions\AuthenticationException
     */
    public function activate(array $data, $validate = true)
    {
        $this->rules = [
          'email'           => 'required|email',
          'activation_code' => 'required',
        ];

        if ($validate) {
            $this->validate($data);
        }

        $user = $this->findByCredentials(['login' => $data['email']]);

        if (!Activation::complete($user, $data['activation_code'])) {
            throw new AuthenticationException('Activation could not be completed.');
        }

        return;
    }

    /**
     * Find user by login credentials.
     *
     * @param $credentials
     *
     * @return mixed
     */
    public function findByCredentials($credentials)
    {
        return Sentinel::findByCredentials($credentials);
    }

    /**
     * Logout the user.
     *
     * @return void
     */
    public function logout()
    {
        Sentinel::logout();

        return;
    }
}