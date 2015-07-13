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

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Odotmedia\Dashboard\Exceptions\AuthenticationException;
use Odotmedia\Dashboard\Exceptions\FormValidationException;
use Odotmedia\Dashboard\Exceptions\UsersException;

class AccountController extends BaseDashboardController
{

    /**
     * Edit account information.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return $this->view('account.edit');
    }

    /**
     * Update account information.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->input('action') == 'update_account') {
            try {
                $this->userRepositoryInterface->update($request->all(), $id);
            } catch (FormValidationException $e) {
                Flash::error($e->getMessage());

                return redirect()
                  ->route('account.edit')
                  ->withErrors($e->getErrors())
                  ->withInput();
            } catch (UsersException $e) {
                Flash::error($e->getMessage());

                return redirect()->route('dashboard.index');
            }

            Flash::success('Account successfully updated.');

            return redirect()->route('account.edit');
        }

        if ($request->input('action') == 'change_password') {
            // Need to setup this.
        }
    }
}