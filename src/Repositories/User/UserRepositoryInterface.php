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

interface UserRepositoryInterface
{
    /**
     * Return all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll();

    /**
     * Return all users with relationship.
     *
     * @param $type
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllWith($type);

    /**
     * Get user by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * Get user by id with relationship.
     *
     * @param int    $id
     * @param string $type
     *
     * @return $this
     */
    public function getByIdWith($id, $type);

    /**
     * Create user.
     *
     * @param array $data
     *
     * @return bool
     * @throws \Laraflock\Dashboard\Exceptions\AuthenticationException
     */
    public function create(array $data, $validate = true);

    /**
     * Update user.
     *
     * @param array $data
     * @param int   $id
     * @param bool  $validate
     *
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     * @throws \Laraflock\Dashboard\Exceptions\RolesException
     * @throws \Laraflock\Dashboard\Exceptions\UsersException
     */
    public function update(array $data, $id, $validate = true);

    /**
     * Update Password
     *
     * @param array $data
     * @param bool  $validate
     *
     * @throws \Laraflock\Dashboard\Exceptions\AuthenticationException
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     */
    public function updatePassword(array $data, $validate = true);

    /**
     * Delete user.
     *
     * @param int $id
     *
     * @throws \Laraflock\Dashboard\Exceptions\UsersException
     */
    public function delete($id);
}