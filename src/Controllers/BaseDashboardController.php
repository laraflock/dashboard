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

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Routing\Controller;
use Odotmedia\Dashboard\Services\Auth\AuthService;

class BaseDashboardController extends Controller
{
    /**
     * Auth service instance.
     *
     * @var \Odotmedia\Dashboard\Services\Auth\AuthService
     */
    protected $authService;

    /**
     * The constructor.
     *
     * @param \Odotmedia\Dashboard\Services\Auth\AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->middleware('user');

        $this->middleware('roles:administrator');

        $this->authService = $authService;

        $user = $this->authService->getActiveUser();

        view()->share('activeUser', $user);
    }
}