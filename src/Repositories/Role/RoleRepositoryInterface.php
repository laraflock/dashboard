<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Repositories\Role;

interface RoleRepositoryInterface
{
    /**
     * Return all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll();

    /**
     * Get role by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * Get role by slug.
     *
     * @param string $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);

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
    public function create(array $data, $validate = true);

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
    public function update(array $data, $id, $validate = true);

    /**
     * Delete role.
     *
     * @param int $id
     *
     * @throws \Odotmedia\Dashboard\Exceptions\RolesException
     */
    public function delete($id);
}