<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Services\Role;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Odotmedia\Dashboard\Exceptions\RolesException;
use Odotmedia\Dashboard\Services\Base\BaseService;

class RoleService extends BaseService
{
    /**
     * Return all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return EloquentRole::all();
    }

    /**
     * Get role by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return Sentinel::findRoleById($id);
    }

    /**
     * Get role by slug.
     *
     * @param string $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return Sentinel::findRoleBySlug($slug);
    }

    /**
     * Create role.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @return mixed
     *
     * @throws \Odotmedia\Dashboard\Exceptions\FormValidationException
     * @throws \Odotmedia\Dashboard\Exceptions\RolesException
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

        if (!$role = Sentinel::getRoleRepository()
                             ->createModel()
                             ->create($data)
        ) {
            throw new RolesException('Role could not be created.');
        }

        return $role;
    }

    /**
     * Update role.
     *
     * @param array $data
     * @param int   $id
     * @param bool  $validate
     *
     * @throws \Odotmedia\Dashboard\Exceptions\FormValidationException
     * @throws \Odotmedia\Dashboard\Exceptions\RolesException
     */
    public function update(array $data, $id, $validate = true)
    {
        if (!$role = $this->getById($id)) {
            throw new RolesException('Role could not be found.');
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

        if (!isset($data['permissions'])) {
            $data['permissions'] = [];
        }

        $role->name        = $data['name'];
        $role->slug        = $data['slug'];
        $role->permissions = $data['permissions'];
        $role->save();

        return;
    }

    /**
     * Delete role.
     *
     * @param int $id
     *
     * @throws \Odotmedia\Dashboard\Exceptions\RolesException
     */
    public function delete($id)
    {
        if (!$role = $this->getById($id)) {
            throw new RolesException('Role could not be found.');
        }

        $role->delete();

        return;
    }
}