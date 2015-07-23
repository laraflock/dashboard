<?php

/**
 * @package     Dashboard
 * @version     3.0.0
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
use Laraflock\Dashboard\Exceptions\UsersException;

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
            try {
                $this->userRepositoryInterface->updatePassword($request->all());
            } catch (FormValidationException $e) {
                Flash::error($e->getMessage());

                return redirect()
                  ->route('account.edit')
                  ->withErrors($e->getErrors());
            } catch (AuthenticationException $e) {
                Flash::error('Old password is incorrect.');

                return redirect()
                  ->route('account.edit');
            }

            Flash::success('Password successfully updated.');

            return redirect()->route('account.edit');
        }
    }
}