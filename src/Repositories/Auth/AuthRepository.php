<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Repositories\Auth;

use Cartalyst\Sentinel\Activations\IlluminateActivationRepository;
use Cartalyst\Sentinel\Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\QueryException;
use Laraflock\Dashboard\Exceptions\AuthenticationException;
use Laraflock\Dashboard\Exceptions\RolesException;
use Laraflock\Dashboard\Repositories\Base\BaseRepository;

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
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.incorrect'));
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

        if (!config('laraflock.dashboard.activations')) {
            $this->registerAndActivate($data, false);

            return true;
        }

        try {
            $user = $this->sentinel->register($data);
        } catch (QueryException $e) {
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.create'));
        }

        if (!$user instanceof EloquentUser) {
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.create'));
        }

        if (!isset($data['role'])) {
            $data['role'] = config('laraflock.dashboard.defaultRole');
        }

        if (!$role = $this->sentinel->findRoleBySlug($data['role'])) {
            throw new RolesException(trans('dashboard::dashboard.errors.role.found'));
        }

        $role->users()
             ->attach($user);

        if (!$activation = $this->illuminateActivationRepository->create($user)) {
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.activation.create'));
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

        try {
            $user = $this->sentinel->registerAndActivate($data);
        } catch (QueryException $e) {
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.create'));
        }

        if (!isset($data['role'])) {
            $data['role'] = config('laraflock.dashboard.defaultRole');
        }

        if (!$role = $this->sentinel->findRoleBySlug($data['role'])) {
            throw new RolesException(trans('dashboard::dashboard.errors.role.found'));
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
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.activation.complete'));
        }

        return true;
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
        return $this->sentinel->login($user);
    }

    /**
     * {@inheritDoc}
     */
    public function logout()
    {
        return $this->sentinel->logout();
    }
}