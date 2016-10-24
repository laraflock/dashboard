<?php

/**
 * @package   Dashboard
 * @author    Ian Olson <me@ianolson.io>
 * @license   MIT
 * @copyright 2015, Laraflock
 * @link      https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface as Auth;

class PermissionMiddleware
{
    /**
     * Auth interface.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * The constructor.
     *
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Check if user has permission.
     *
     * @param Request      $request
     * @param Closure      $next
     * @param string|array $permissions
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (!$user = $this->auth->getActiveUser()) {
            Flash::error(trans('dashboard::dashboard.flash.access_denied'));
            return redirect()->back();
        }

        if (!is_array($permissions)) {
            $permissions = [$permissions];
        }

        if ($user->hasAnyAccess($permissions)) {
            return $next($request);
        }

        Flash::error(trans('dashboard::dashboard.flash.access_denied'));
        return redirect()->back();
    }
}
