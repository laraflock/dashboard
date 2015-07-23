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

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Laraflock\Dashboard\Exceptions\AuthenticationException;
use Laraflock\Dashboard\Exceptions\FormValidationException;
use Laraflock\Dashboard\Exceptions\RolesException;
use Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface;

class AuthController extends BaseDashboardController
{
    /**
     * Auth interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface
     */
    protected $authRepositoryInterface;

    /**
     * The constructor.
     *
     * @param \Laraflock\Dashboard\Repositories\Auth\AuthRepositoryInterface $authRepositoryInterface
     */
    public function __construct(AuthRepositoryInterface $authRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;

        $viewNamespace = config('laraflock.dashboard.viewNamespace');

        view()->share(['viewNamespace' => $viewNamespace]);
    }

    /**
     * Display login screen.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return $this->view('auth.login');
    }

    /**
     * Authenticate and Validate login input.
     *
     * @param Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function authentication(Request $request)
    {
        try {
            $this->authRepositoryInterface->authenticate($request->all());
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('auth.login')
              ->withErrors($e->getErrors());
        } catch (AuthenticationException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('auth.login');
        }

        return redirect()->route('dashboard.index');
    }

    /**
     * Display registration screen.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function register()
    {
        if (!config('laraflock.dashboard.registration')) {
            Flash::error('Registration is not active. Please login.');

            return redirect()->route('auth.login');
        }

        return $this->view('auth.register');
    }

    /**
     * Register the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function registration(Request $request)
    {
        if (!config('laraflock.dashboard.registration')) {
            Flash::error('Registration is not active. Please login.');

            return redirect()->route('auth.login');
        }

        try {
            $this->authRepositoryInterface->register($request->all());
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('auth.register')
              ->withErrors($e->getErrors())
              ->withInput();
        } catch (RolesException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('auth.register')
              ->withInput();
        }

        if (!config('laraflock.dashboard.activations')) {
            Flash::success('Account activated. Please login below.');

            return redirect()->route('auth.login');
        }

        Flash::success('Account created. Activation needed, please check your email.');

        return redirect()->route('auth.login');
    }

    /**
     * Display activate screen.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function activate(Request $request)
    {
        if (!$email = $request->get('email')) {
            $email = null;
        }

        if (!$code = $request->get('code')) {
            $code = null;
        }

        if (!config('laraflock.dashboard.activations')) {
            Flash::error('Activations are not active. Please login.');

            return redirect()->route('auth.login');
        }

        return $this->view('auth.activate')->with(['email' => $email, 'code' => $code]);
    }

    /**
     * Activate a user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return $this
     */
    public function activation(Request $request)
    {
        if (!config('laraflock.dashboard.activations')) {
            Flash::error('Activations are not active. Please login.');

            return redirect()->route('auth.login');
        }

        try {
            $this->authRepositoryInterface->activate($request->all());
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('auth.activate')
              ->withErrors($e->getErrors())
              ->withInput();
        } catch (AuthenticationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('auth.activate')
              ->withInput();
        }

        Flash::success('Account successfully activated.');

        return redirect()->route('auth.login');
    }

    /**
     * Unauthorized view.
     *
     * @return \Illuminate\View\View
     */
    public function unauthorized()
    {
        return $this->view('auth.unauthorized');
    }

    /**
     * Trigger logout of session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $this->authRepositoryInterface->logout();

        return redirect()->route('auth.login');
    }
}
