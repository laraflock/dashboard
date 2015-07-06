<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

use Odotmedia\Dashboard\Exceptions\AuthenticationException;
use Odotmedia\Dashboard\Exceptions\FormValidationException;
use Odotmedia\Dashboard\Exceptions\PermissionsException;
use Odotmedia\Dashboard\Exceptions\RolesException;
use Odotmedia\Dashboard\Exceptions\UsersException;

class ExceptionTest extends TestCase
{
    /**
     * Test: AuthenticationException
     *
     * @throws \Odotmedia\Dashboard\Exceptions\AuthenticationException
     */
    public function testAuthenticationException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\AuthenticationException');
        throw new AuthenticationException('Test Message');
    }

    /**
     * Test: FormValidationException
     *
     * @throws \Odotmedia\Dashboard\Exceptions\FormValidationException
     */
    public function testFormValidationException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\FormValidationException');
        throw new FormValidationException('Test Message');
    }

    /**
     * Test: PermissionsException
     *
     * @throws \Odotmedia\Dashboard\Exceptions\PermissionsException
     */
    public function testPermissionsException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\PermissionsException');
        throw new PermissionsException('Test Message');
    }

    /**
     * Test: RolesException
     *
     * @throws \Odotmedia\Dashboard\Exceptions\RolesException
     */
    public function testRolesException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\RolesException');
        throw new RolesException('Test Message');
    }

    /**
     * Test: UsersException
     *
     * @throws \Odotmedia\Dashboard\Exceptions\UsersException
     */
    public function testUsersException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\UsersException');
        throw new UsersException('Test Message');
    }
}