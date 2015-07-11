<?php

namespace Odotmedia\Dashboard\Repositories\User;

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
     * @throws \Odotmedia\Dashboard\Exceptions\AuthenticationException
     */
    public function create(array $data, $validate = true);

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
    public function update(array $data, $id, $validate = true);

    /**
     * Delete user.
     *
     * @param int $id
     *
     * @throws \Odotmedia\Dashboard\Exceptions\UsersException
     */
    public function delete($id);
}