<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Repositories\Permission;

use Illuminate\Database\QueryException;
use Odotmedia\Dashboard\Exceptions\PermissionsException;
use Odotmedia\Dashboard\Models\Permission;
use Odotmedia\Dashboard\Repositories\Base\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * Permission instance.
     *
     * @var \Odotmedia\Dashboard\Models\Permission
     */
    protected $permission;

    /**
     * The constructor.
     *
     * @param \Odotmedia\Dashboard\Models\Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll()
    {
        return $this->permission->all();
    }

    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        return $this->permission->find($id);
    }

    /**
     * {@inheritDoc}
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

        try {
            $permission = $this->permission->create($data);
        } catch (QueryException $e) {
            throw new PermissionsException('Permission could not be created.');
        }

        return $permission;
    }

    /**
     * {@inheritDoc}
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

        return $permission;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        if (!$permission = $this->getById($id)) {
            throw new PermissionsException('Permission could not be found.');
        }

        $permission->delete();

        return true;
    }
}