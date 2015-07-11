<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Repositories\User;

use Cartalyst\Sentinel\Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;
use Odotmedia\Dashboard\Exceptions\RolesException;
use Odotmedia\Dashboard\Exceptions\UsersException;
use Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface;
use Odotmedia\Dashboard\Repositories\Base\BaseRepository;
use Odotmedia\Dashboard\Repositories\Role\RoleRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Auth interface.
     *
     * @var \Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface
     */
    protected $auth;

    /**
     * Role interface.
     *
     * @var \Odotmedia\Dashboard\Repositories\Role\RoleRepositoryInterface
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
     * @param \Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface $auth
     * @param \Odotmedia\Dashboard\Repositories\Role\RoleRepositoryInterface $role
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
     * Return all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->user->all();
    }

    /**
     * Return all users with relationship.
     *
     * @param $type
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllWith($type)
    {
        return $this->user->with($type)
                          ->get();
    }

    /**
     * Get user by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return $this->user->find($id);
    }

    /**
     * Get user by id with relationship.
     *
     * @param int    $id
     * @param string $type
     *
     * @return $this
     */
    public function getByIdWith($id, $type)
    {
        return $this->user->with($type)
                          ->where('id', '=', $id)
                          ->first();
    }

    /**
     * Create user.
     *
     * @param array $data
     *
     * @return bool
     * @throws \Odotmedia\Dashboard\Exceptions\AuthenticationException
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
     * Update user.
     *
     * @param array $data
     * @param int   $id
     * @param bool  $validate
     *
     * @throws \Odotmedia\Dashboard\Exceptions\FormValidationException
     * @throws \Odotmedia\Dashboard\Exceptions\RolesException
     * @throws \Odotmedia\Dashboard\Exceptions\UsersException
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
     * Delete user.
     *
     * @param int $id
     *
     * @throws \Odotmedia\Dashboard\Exceptions\UsersException
     */
    public function delete($id)
    {
        if (!$user = $this->getById($id)) {
            throw new UsersException('User cannot be found.');
        }

        $user->delete();

        return;
    }
}