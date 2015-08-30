<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Controllers;

use Illuminate\Routing\Controller;
use Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface;
use Laraflock\Dashboard\Repositories\Module\ModuleRepositoryInterface;
use Laraflock\Dashboard\Repositories\Permission\PermissionRepositoryInterface;
use Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface;
use Laraflock\Dashboard\Repositories\User\UserRepositoryInterface;

class BaseDashboardController extends Controller
{
    /**
     * Auth interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface
     */
    protected $authRepositoryInterface;

    /**
     * Permission interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Permission\PermissionRepositoryInterface
     */
    protected $permissionRepositoryInterface;

    /**
     * Role interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface
     */
    protected $roleRepositoryInterface;

    /**
     * User interface.
     *
     * @var \Laraflock\Dashboard\Repositories\User\UserRepositoryInterface
     */
    protected $userRepositoryInterface;

    /**
     * The constructor.
     *
     * @param \Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface $authRepositoryInterface
     * @param \Laraflock\Dashboard\Repositories\Permission\PermissionRepositoryInterface $permissionRepositoryInterface
     * @param \Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface $roleRepositoryInterface
     * @param \Laraflock\Dashboard\Repositories\User\UserRepositoryInterface $userRepositoryInterface
     * @param \Laraflock\Dashboard\Repositories\Module\ModuleRepositoryInterface $moduleRepositoryInterface
     */
    public function __construct(
        AuthRepositoryInterface $authRepositoryInterface,
        PermissionRepositoryInterface $permissionRepositoryInterface,
        RoleRepositoryInterface $roleRepositoryInterface,
        UserRepositoryInterface $userRepositoryInterface,
        ModuleRepositoryInterface $moduleRepositoryInterface
    )
    {
        $viewNamespace = config('laraflock.dashboard.viewNamespace');

        $this->authRepositoryInterface       = $authRepositoryInterface;
        $this->permissionRepositoryInterface = $permissionRepositoryInterface;
        $this->roleRepositoryInterface       = $roleRepositoryInterface;
        $this->userRepositoryInterface       = $userRepositoryInterface;

        $user = $this->authRepositoryInterface->getActiveUser();

        view()->share([
            'activeUser' => $user,
            'viewNamespace' => $viewNamespace,
            'modules' => $moduleRepositoryInterface
        ]);
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
        return view(sprintf("%s::%s", config('laraflock.dashboard.viewNamespace'), $view), $data);
    }
}