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
     * @param string|array $permission
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        // Check to see if the user is logged in.
        if (!$user = $this->auth->getActiveUser()) {
            Flash::error('Access Denied');

            return redirect()->route('auth.login');
        }

        if (!$user->hasAccess($permission)) {
            Flash::error('Access Denied');

            // Redirect back to the previous page where request was made.
            return redirect()->back();
        }

        return $next($request);
    }
}