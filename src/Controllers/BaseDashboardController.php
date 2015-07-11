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

use Illuminate\Routing\Controller;
use Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface;
use Odotmedia\Dashboard\Repositories\Permission\PermissionRepositoryInterface;
use Odotmedia\Dashboard\Repositories\Role\RoleRepositoryInterface;
use Odotmedia\Dashboard\Repositories\User\UserRepositoryInterface;

class BaseDashboardController extends Controller
{
    /**
     * Auth interface.
     *
     * @var \Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface
     */
    protected $authRepositoryInterface;

    /**
     * Permission interface.
     *
     * @var \Odotmedia\Dashboard\Repositories\Permission\PermissionRepositoryInterface
     */
    protected $permissionRepositoryInterface;

    /**
     * Role interface.
     *
     * @var \Odotmedia\Dashboard\Repositories\Role\RoleRepositoryInterface
     */
    protected $roleRepositoryInterface;

    /**
     * User interface.
     *
     * @var \Odotmedia\Dashboard\Repositories\User\UserRepositoryInterface
     */
    protected $userRepositoryInterface;

    /**
     * The constructor.
     *
     * @param \Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface             $authRepositoryInterface
     * @param \Odotmedia\Dashboard\Repositories\Permission\PermissionRepositoryInterface $permissionRepositoryInterface
     * @param \Odotmedia\Dashboard\Repositories\Role\RoleRepositoryInterface             $roleRepositoryInterface
     * @param \Odotmedia\Dashboard\Repositories\User\UserRepositoryInterface             $userRepositoryInterface
     */
    public function __construct(AuthRepositoryInterface $authRepositoryInterface, PermissionRepositoryInterface $permissionRepositoryInterface, RoleRepositoryInterface $roleRepositoryInterface, UserRepositoryInterface $userRepositoryInterface)
    {
        $this->middleware('user');

        $this->middleware('roles:administrator');

        $viewNamespace = config('odotmedia.dashboard.viewNamespace');

        $this->authRepositoryInterface       = $authRepositoryInterface;
        $this->permissionRepositoryInterface = $permissionRepositoryInterface;
        $this->roleRepositoryInterface       = $roleRepositoryInterface;
        $this->userRepositoryInterface       = $userRepositoryInterface;

        $user = $this->authRepositoryInterface->getActiveUser();

        view()->share(['activeUser' => $user, 'viewNamespace' => $viewNamespace]);
    }

    /**
     * Parses a view, using the package view namespace
     *
     * @param       $view
     * @param array $data
     *
     * @return \Illuminate\View\View
     */
    public function view($view, $data = [])
    {
        return view(sprintf("%s::%s", config('odotmedia.dashboard.viewNamespace'), $view), $data);
    }
}