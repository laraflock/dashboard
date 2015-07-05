<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Controllers;

use Odotmedia\Dashboard\Controllers\BaseDashboardController;
use Odotmedia\Dashboard\Services\User\UserService;

class AccountController extends BaseDashboardController
{
    /**
     * User service.
     *
     * @var \Odotmedia\Dashboard\Services\User\UserService
     */
    protected $userService;

    /**
     * The constructor.
     *
     * @param \Odotmedia\Dashboard\Services\User\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        parent::__construct();
    }

    /**
     * Edit account information.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('dashboard::account.edit');
    }

    /**
     * Update account information.
     *
     * @todo finish this update method
     */
    public function update()
    {

    }
}