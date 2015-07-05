<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Services\User;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;
use Odotmedia\Dashboard\Exceptions\RolesException;
use Odotmedia\Dashboard\Exceptions\UsersException;
use Odotmedia\Dashboard\Services\Auth\AuthService;
use Odotmedia\Dashboard\Services\Base\BaseService;
use Odotmedia\Dashboard\Services\Role\RoleService;

class UserService extends BaseService
{
    /**
     * Return all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return EloquentUser::all();
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
        return EloquentUser::with($type)
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
        return EloquentUser::find($id);
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
        return EloquentUser::with($type)
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

        $authService = new AuthService();
        $authService->registerAndActivate($data);

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

        Sentinel::update($user, $data);

        if (isset($data['role'])) {

            $roleService = new RoleService();

            if (!$role = $roleService->getBySlug($data['role'])) {
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