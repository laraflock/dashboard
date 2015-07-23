<?php

/**
 * @package     Dashboard
 * @version     3.0.0
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

class RoleRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->setupData();
    }

    protected function setupData()
    {
        $data = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $this->roleRepository->create($data);
    }

    public function testGetAll()
    {
        $roles = $this->roleRepository->getAll();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $roles);
    }

    public function testGetById()
    {
        $role = $this->roleRepository->getById(1);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Roles\EloquentRole::class, $role);
    }

    public function testGetByIdNull()
    {
        $role = $this->roleRepository->getById(2);

        $this->assertNull($role);
    }

    public function testCreate()
    {
        $data = [
          'name' => 'Administrator',
          'slug' => 'admin',
        ];

        $role = $this->roleRepository->create($data, false);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Roles\EloquentRole::class, $role);
    }

    public function testCreateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $data = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $this->roleRepository->create($data);
    }

    public function testCreateRolesException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\RolesException');

        $data = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $this->roleRepository->create($data, false);
    }

    public function testUpdate()
    {
        $data = [
          'name' => 'Registered2',
          'slug' => 'registered',
        ];

        $role = $this->roleRepository->update($data, 1);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Roles\EloquentRole::class, $role);
    }

    public function testUpdateRolesException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\RolesException');

        $data = [
          'name' => 'Registered2',
          'slug' => 'registered',
        ];

        $this->roleRepository->update($data, 2);
    }

    public function testUpdateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $data = [
          'name' => 'Registered 2',
          'slug' => 'registered space',
        ];

        $this->roleRepository->update($data, 1);
    }

    public function testDelete()
    {
        $delete = $this->roleRepository->delete(1);

        $this->assertTrue($delete);
    }

    public function testDeleteRolesException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\RolesException');

        $this->roleRepository->delete(2);
    }
}