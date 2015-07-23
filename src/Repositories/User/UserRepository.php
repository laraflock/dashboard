<?php

/**
 * @package     Dashboard
 * @version     3.0.0
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Repositories\User;

use Cartalyst\Sentinel\Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;
use Laraflock\Dashboard\Exceptions\RolesException;
use Laraflock\Dashboard\Exceptions\UsersException;
use Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface;
use Laraflock\Dashboard\Repositories\Base\BaseRepository;
use Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Auth interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface
     */
    protected $auth;

    /**
     * Role interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface
     */
    protected $role;

    /**
     * Sentinel instance.
     *
     * @var \Cartalyst\Sentinel\Sentinel
     */
    protected $sentinel;

    /**
     * User instance.
     *
     * @var \Cartalyst\Sentinel\Users\EloquentUser
     */
    protected $user;

    /**
     * The constructor.
     *
     * @param \Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface $auth
     * @param \Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface $role
     * @param \Cartalyst\Sentinel\Sentinel                                   $sentinel
     * @param \Cartalyst\Sentinel\Users\EloquentUser                         $user
     */
    public function __construct(AuthRepositoryInterface $auth, RoleRepositoryInterface $role, Sentinel $sentinel, EloquentUser $user)
    {
        $this->auth     = $auth;
        $this->role     = $role;
        $this->sentinel = $sentinel;
        $this->user     = $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll()
    {
        return $this->user->all();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllWith($type)
    {
        return $this->user->with($type)
                          ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        return $this->user->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getByIdWith($id, $type)
    {
        return $this->user->with($type)
                          ->where('id', '=', $id)
                          ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data, $validate = true)
    {
        $this->rules = [
          'email'                 => 'required|unique:users',
          'password'              => 'required|confirmed',
          'password_confirmation' => 'required',
        ];

        if ($validate) {
            $this->validate($data);
        }

        $this->auth->registerAndActivate($data);

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function update(array $data, $id, $validate = true)
    {
        if (!$user = $this->getById($id)) {
            throw new UsersException('User could not be found.');
        }

        if ($user->email != $data['email']) {
            $this->rules['email'] = 'required|email|unique:users';
        } else {
            $this->rules['email'] = 'required|email';
        }

        if ($validate) {
            $this->validate($data);
        }

        $this->sentinel->update($user, $data);

        if (isset($data['role'])) {

            if (!$role = $this->role->getBySlug($data['role'])) {
                throw new RolesException('Role could not be found.');
            }

            if (!$user->inRole($role)) {
                $role->users()
                     ->attach($user);
            }
        }

        $user->save();

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function updatePassword(array $data, $validate = true)
    {
        $user = $this->auth->authenticate($data);

        $this->rules = [
          'new_password'              => 'required|confirmed',
          'new_password_confirmation' => 'required',
        ];

        if ($validate) {
            $this->validate($data);
        }

        $updatedData = [
          'password' => $data['new_password'],
        ];

        $this->sentinel->update($user, $updatedData);

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        if (!$user = $this->getById($id)) {
            throw new UsersException('User could not be found.');
        }

        $user->delete();

        return;
    }
}