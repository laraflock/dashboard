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

interface PermissionRepositoryInterface
{
    /**
     * Return all permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll();

    /**
     * Get permission by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * Create permission.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @return static
     * @throws \Odotmedia\Dashboard\Exceptions\FormValidationException
     */
    public function create(array $data, $validate = true);

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
    public function update(array $data, $id, $validate = true);

    /**
     * Delete permission.
     *
     * @param int $id
     *
     * @throws \Odotmedia\Dashboard\Exceptions\PermissionsException
     */
    public function delete($id);
}