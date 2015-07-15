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

class DashboardController extends BaseDashboardController
{
    /**
     * The dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return $this->view('dashboard.index');
    }
}