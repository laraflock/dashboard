<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Repositories\Role;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\QueryException;
use Laraflock\Dashboard\Exceptions\RolesException;
use Laraflock\Dashboard\Repositories\Base\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * EloquentRole instance.
     *
     * @var \Cartalyst\Sentinel\Roles\EloquentRole
     */
    protected $role;

    /**
     * Sentinel instance.
     *
     * @var \Cartalyst\Sentinel\Sentinel
     */
    protected $sentinel;

    public function __construct(EloquentRole $role, Sentinel $sentinel)
    {
        $this->role     = $role;
        $this->sentinel = $sentinel;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll()
    {
        return $this->role->all();
    }

    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        return $this->sentinel->findRoleById($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getBySlug($slug)
    {
        return $this->sentinel->findRoleBySlug($slug);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data, $validate = true)
    {
        $this->rules = [
          'slug' => 'required|alpha_dash|unique:roles',
          'name' => 'required|alpha_dash|unique:roles',
        ];

        if ($validate) {
            $this->validate($data);
        }

        // Convert the checkbox values of "1" to true, so permission checking works with Sentinel.
        if (isset($data['permissions'])) {
            foreach ($data['permissions'] as $permission => $value) {
                $data['permissions'][$permission] = true;
            }
        }

        try {
            $role = $this->sentinel->getRoleRepository()
                                   ->createModel()
                                   ->create($data);
        } catch (QueryException $e) {
            throw new RolesException(trans('laraflock.dashboard.errors.role.create'));
        }

        return $role;
    }

    /**
     * {@inheritDoc}
     */
    public function update(array $data, $id, $validate = true)
    {
        if (!$role = $this->getById($id)) {
            throw new RolesException(trans('laraflock.dashboard.errors.role.found'));
        }

        if ($role->name != $data['name']) {
            $this->rules['name'] = 'required|alpha_dash|unique:roles';
        } else {
            $this->rules['name'] = 'required|alpha_dash';
        }

        if ($role->slug != $data['slug']) {
            $this->rules['slug'] = 'required|alpha_dash|unique:roles';
        } else {
            $this->rules['slug'] = 'required|alpha_dash';
        }

        if ($validate) {
            $this->validate($data);
        }

        // Convert the checkbox values of "1" to true, so permission checking works with Sentinel.
        if (isset($data['permissions'])) {
            foreach ($data['permissions'] as $permission => $value) {
                $data['permissions'][$permission] = true;
            }
        } else {
            $data['permissions'] = [];
        }

        $role->name        = $data['name'];
        $role->slug        = $data['slug'];
        $role->permissions = $data['permissions'];
        $role->save();

        return $role;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        if (!$role = $this->getById($id)) {
            throw new RolesException(trans('laraflock.dashboard.errors.role.found'));
        }

        $role->delete();

        return true;
    }
}