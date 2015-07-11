<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Repositories\Auth;

use Cartalyst\Sentinel\Activations\IlluminateActivationRepository;
use Cartalyst\Sentinel\Sentinel;
use Odotmedia\Dashboard\Exceptions\AuthenticationException;
use Odotmedia\Dashboard\Exceptions\RolesException;
use Odotmedia\Dashboard\Repositories\Base\BaseRepository;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    /**
     * Activation interface.
     *
     * @var \Cartalyst\Sentinel\Activations\ActivationRepositoryInterface
     */
    protected $illuminateActivationRepository;

    /**
     * Sentinel instance.
     *
     * @var \Cartalyst\Sentinel\Sentinel
     */
    protected $sentinel;

    /**
     * The constructor.
     *
     * @param \Cartalyst\Sentinel\Sentinel $sentinel
     */
    public function __construct(IlluminateActivationRepository $illuminateActivationRepository, Sentinel $sentinel)
    {
        $this->illuminateActivationRepository = $illuminateActivationRepository;
        $this->sentinel                       = $sentinel;
    }

    /**
     * {@inheritDoc}
     */
    public function getActiveUser()
    {
        return $this->sentinel->getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function check()
    {
        return $this->sentinel->check();
    }

    /**
     * {@inheritDoc}
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

        if (!$user = $this->sentinel->authenticate($data, $remember)) {
            throw new AuthenticationException('Email \ Password combination incorrect.');
        }

        return $user;
    }

    /**
     * {@inheritDoc}
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

        if (!$user = $this->sentinel->register($data)) {
            throw new AuthenticationException('User could not be created.');
        }

        if (!$activation = $this->illuminateActivationRepository->create($user)) {
            throw new AuthenticationException('Activation could not be created.');
        }

        return $activation;
    }

    /**
     * {@inheritDoc}
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

        if (!$user = $this->sentinel->registerAndActivate($data)) {
            throw new AuthenticationException('User could not be created.');
        }

        if (!isset($data['role'])) {
            $data['role'] = config('odotmedia.dashboard.defaultRole');
        }

        if (!$role = $this->sentinel->findRoleBySlug($data['role'])) {
            throw new RolesException('Role could not be found.');
        }

        $role->users()
             ->attach($user);

        return;
    }

    /**
     * {@inheritDoc}
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

        if (!$this->illuminateActivationRepository->complete($user, $data['activation_code'])) {
            throw new AuthenticationException('Activation could not be completed.');
        }

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function findByCredentials(array $data)
    {
        return $this->sentinel->findByCredentials($data);
    }

    /**
     * {@inheritDoc}
     */
    public function login($user)
    {
        $this->sentinel->login($user);

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function logout()
    {
        $this->sentinel->logout();

        return;
    }
}