<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface as Auth;
use Laraflock\Dashboard\Repositories\Role\RoleRepositoryInterface as Role;

class RoleMiddleware
{
    /**
     * Auth interface.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Role interface.
     *
     * @var Role
     */
    protected $role;

    /**
     * The constructor.
     *
     * @param Auth $auth
     * @param Role $role
     */
    public function __construct(Auth $auth, Role $role)
    {
        $this->auth = $auth;
        $this->role = $role;
    }

    /**
     * Check if user belongs to the specified role.
     *
     * @param Request      $request
     * @param Closure      $next
     * @param string|array $roles
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $accessDenied = true;

        if (!$user = $this->auth->getActiveUser()) {
            Flash::error(trans('dashboard::dashboard.flash.access_denied'));

            return redirect()->route('auth.login');
        }

        if (!is_array($roles)) {
            $roles = [$roles];
        }

        foreach ($roles as $role) {

            if (!$role = $this->role->getBySlug($role)) {
                continue;
            }

            if ($user->inRole($role)) {
                $accessDenied = false;
            }
        }

        if ($accessDenied) {
            Flash::error(trans('dashboard::dashboard.flash.access_denied'));

            // Redirect back to the previous page where request was made.
            return redirect()->back();
        }

        return $next($request);
    }
}