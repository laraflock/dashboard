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

class UserMiddleware
{
    /**
     * Auth repository interface.
     *
     * @var \Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface
     */
    protected $authRepositoryInterface;

    /**
     * The constructor.
     *
     * @param \Odotmedia\Dashboard\Repositories\Auth\AuthRepositoryInterface $authRepositoryInterface
     */
    public function __construct(AuthRepositoryInterface $authRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
    }

    /**
     * Check if a user is logged in.
     *
     * @param Request  $request
     * @param callable $next
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->authRepositoryInterface->check()) {
            if ($request->ajax()) {
                return response('Unauthorized', 401);
            } else {
                Flash::error('Access Denied');

                return redirect()->route('auth.login');
            }
        }

        return $next($request);
    }
}