<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Controllers;

use Illuminate\Routing\Controller;
use Laraflock\Dashboard\Composers\ViewComposer;

class BaseDashboardController extends Controller
{

    /**
     * Parses a view, using the package view namespace
     *
     * @param       $view
     * @param array $data
     *
     * @return \Illuminate\View\View
     */
    public function view($view, $data = [])
    {
        view()->composer('*', ViewComposer::class);
        return view(sprintf("%s::%s", config('laraflock.dashboard.viewNamespace'), $view), $data);
    }
}