<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Repositories\Auth;

interface AuthRepositoryInterface
{
    /**
     * Get active user.
     *
     * @return mixed
     */
    public function getActiveUser();

    /**
     * Check if user is logged in.
     *
     * @return mixed
     */
    public function check();

    /**
     * Authenticate the user.
     *
     * @param array $data
     *
     * @throws \Laraflock\Dashboard\Exceptions\AuthenticationException
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     *
     * @return mixed
     */
    public function authenticate(array $data);

    /**
     * Register a user.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @throws \Laraflock\Dashboard\Exceptions\AuthenticationException
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     * @throws \Laraflock\Dashboard\Exceptions\RolesException
     *
     * @return mixed
     */
    public function register(array $data, $validate = true);

    /**
     * Register and activate user if activations are false.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @throws \Laraflock\Dashboard\Exceptions\AuthenticationException
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     * @throws \Laraflock\Dashboard\Exceptions\RolesException
     *
     * @return mixed
     */
    public function registerAndActivate(array $data, $validate = true);

    /**
     * Activate a user.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @throws \Laraflock\Dashboard\Exceptions\AuthenticationException
     *
     * @return mixed
     */
    public function activate(array $data, $validate = true);

    /**
     * Find user by login credentials.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function findByCredentials(array $data);

    /**
     * Login the user.
     *
     * @param $user
     *
     * @return mixed
     */
    public function login($user);

    /**
     * Logout the user.
     *
     * @return mixed
     */
    public function logout();
}