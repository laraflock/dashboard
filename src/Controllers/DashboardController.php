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

use Odotmedia\Dashboard\Controllers\BaseDashboardController;
use Odotmedia\Dashboard\Services\Auth\AuthService;

class DashboardController extends BaseDashboardController
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
        $this->authService = $authService;

        parent::__construct($authService);
    }
    /**
     * The dashboard.
     *
     * @link domain.com/dashboard
     */
    public function dashboard()
    {
        return view('dashboard::dashboard.index');
    }
}