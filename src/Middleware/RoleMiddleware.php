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

use Cartalyst\Sentinel\Sentinel;
use Closure;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Odotmedia\Dashboard\Services\Auth\AuthService;
use Odotmedia\Dashboard\Services\Role\RoleService;

class RoleMiddleware
{
    /**
     * Auth service instance.
     *
     * @var \Odotmedia\Dashboard\Services\Auth\AuthService
     */
    protected $authService;

    /**
     * Role service instance.
     *
     * @var \Odotmedia\Dashboard\Services\Role\RoleService
     */
    protected $roleService;

    /**
     * The constructor.
     *
     * @param \Odotmedia\Dashboard\Services\Auth\AuthService $authService
     * @param \Odotmedia\Dashboard\Services\Role\RoleService $roleService
     */
    public function __construct(AuthService $authService, RoleService $roleService)
    {
        $this->authService = $authService;
        $this->roleService = $roleService;
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

        if (!$user = $this->authService->getActiveUser()) {
            Flash::error('Access Denied');

            return redirect()->route('auth.login');
        }

        if (!$role = $this->roleService->getBySlug($role)) {
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