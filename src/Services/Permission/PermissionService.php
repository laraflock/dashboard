<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Services\Permission;

use Odotmedia\Dashboard\Exceptions\PermissionsException;
use Odotmedia\Dashboard\Models\Permission;
use Odotmedia\Dashboard\Services\Base\BaseService;

class PermissionService extends BaseService
{
    /**
     * Return all permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return Permission::all();
    }

    /**
     * Get permission by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return Permission::find($id);
    }

    /**
     * Create permission.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @return static
     * @throws \Odotmedia\Dashboard\Exceptions\FormValidationException
     */
    public function create(array $data, $validate = true)
    {
        $this->rules = [
          'name' => 'required',
          'slug' => 'required|unique:permissions',
        ];

        if ($validate) {
            $this->validate($data);
        }

        return Permission::create($data);
    }

    /**
     * Update permission.
     *
     * @param array $data
     * @param int   $id
     * @param bool  $validate
     *
     * @throws \Odotmedia\Dashboard\Exceptions\FormValidationException
     * @throws \Odotmedia\Dashboard\Exceptions\PermissionsException
     */
    public function update(array $data, $id, $validate = true)
    {
        if (!$permission = $this->getById($id)) {
            throw new PermissionsException('Permission could not be found.');
        }

        $this->rules = [
          'name' => 'required',
          'slug' => 'required|alpha_dash',
        ];

        if ($permission->slug != $data['slug']) {
            $this->rules['slug'] = 'required|alpha_dash|unique:permissions';
        }

        if ($validate) {
            $this->validate($data);
        }

        $permission->name = $data['name'];
        $permission->slug = $data['slug'];
        $permission->save();

        return;
    }

    /**
     * Delete permission.
     *
     * @param int $id
     *
     * @throws \Odotmedia\Dashboard\Exceptions\PermissionsException
     */
    public function delete($id)
    {
        if (!$permission = $this->getById($id)) {
            throw new PermissionsException('Permission could not be found.');
        }

        $permission->delete();

        return;
    }
}