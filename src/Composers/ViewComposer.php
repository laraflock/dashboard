<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Composers;

use Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface;
use Laraflock\Dashboard\Repositories\Module\ModuleRepositoryInterface;

class ViewComposer {

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
     * @param \Laraflock\Dashboard\Repositories\Module\ModuleRepositoryInterface $moduleRepositoryInterface
     */
    public function __construct(
        AuthRepositoryInterface $authRepositoryInterface,
        ModuleRepositoryInterface $moduleRepositoryInterface
    )
    {
        $viewNamespace = config('laraflock.dashboard.viewNamespace');

        $this->authRepositoryInterface       = $authRepositoryInterface;

        $user = $this->authRepositoryInterface->getActiveUser();

        view()->share([
            'activeUser' => $user,
            'viewNamespace' => $viewNamespace,
            'modules' => $moduleRepositoryInterface
        ]);
    }
}