<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface;
use Odotmedia\Dashboard\Repositories\Role\RoleRepositoryInterface;

class RoleMiddleware
{
    /**
     * Auth repository interface.
     *
     * @var \Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface
     */
    protected $authRepositoryInterface;

    /**
     * Role repository interface.
     *
     * @var \Odotmedia\Dashboard\Repositories\Role\RoleRepositoryInterface
     */
    protected $roleRepositoryInterface;

    /**
     * The constructor.
     *
     * @param \Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface $authRepositoryInterface
     * @param \Odotmedia\Dashboard\Repositories\Role\RoleRepositoryInterface $roleRepositoryInterface
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