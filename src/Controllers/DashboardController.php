<?php

/**
 * @package     Dashboard
 * @version     2.0.0
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Controllers;

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