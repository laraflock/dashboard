<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Composers;

use Illuminate\Contracts\View\View;
use Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface;
use Laraflock\Dashboard\Repositories\Module\ModuleRepositoryInterface;

class ViewComposer {

    /**
     * @var AuthRepositoryInterface
     */
    protected $auth;

    /**
     * @var ModuleRepositoryInterface
     */
    protected $module;

    /**
     * The constructor.
     *
     * @param AuthRepositoryInterface   $auth
     * @param ModuleRepositoryInterface $module
     */
    public function __construct(
        AuthRepositoryInterface $auth,
        ModuleRepositoryInterface $module
    )
    {
        $this->auth       = $auth;
        $this->module    = $module;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view) {

        $viewNamespace = config('laraflock.dashboard.viewNamespace');

        $user = $this->auth->getActiveUser();

        $view->with('activeUser', $user);
        $view->with('viewNamespace', $viewNamespace);
        $view->with('modules', $this->module);
    }
}