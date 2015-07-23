<?php

/**
 * @package     Dashboard
 * @version     2.0.0
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface;
use Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface;

class RoleMiddleware
{
    /**
     * Auth repository interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface
     */
    protected $authRepositoryInterface;

    /**
     * Role repository interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface
     */
    protected $roleRepositoryInterface;

    /**
     * The constructor.
     *
     * @param \Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface $authRepositoryInterface
     * @param \Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface $roleRepositoryInterface
     */
    public function __construct(AuthRepositoryInterface $authRepositoryInterface, RoleRepositoryInterface $roleRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
        $this->roleRepositoryInterface = $roleRepositoryInterface;
    }

    /**
     * Check if user belongs to the specified role.
     *
     * @param \Illuminate\Http\Request $request
     * @param callable                 $next
     * @param                          $role
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($request->ajax()) {
            return response('Unauthorized', 401);
        }

        if (!$user = $this->authRepositoryInterface->getActiveUser()) {
            Flash::error('Access Denied');

            return redirect()->route('auth.login');
        }

        if (!$role = $this->roleRepositoryInterface->getBySlug($role)) {
            Flash::error('Access Denied');

            return redirect()->route('auth.unauthorized');
        }

        if (!$user->inRole($role)) {
            Flash::error('Access Denied');

            return redirect()->route('auth.unauthorized');
        }

        return $next($request);
    }
}