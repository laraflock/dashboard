<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;
use Laraflock\Dashboard\Exceptions\FormValidationException;
use Laraflock\Dashboard\Exceptions\PermissionsException;
use Laraflock\Dashboard\Services\Auth\AuthService;
use Laraflock\Dashboard\Services\Permission\PermissionService;

class PermissionsController extends BaseDashboardController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $permissions = $this->permissionRepositoryInterface->getAll();

        return $this->view('permissions.index')->with(['permissions' => $permissions]);
    }

    /**
     * Create a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $this->permissionRepositoryInterface->create($request->all());
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('permissions.create')
              ->withErrors($e->getErrors())
              ->withInput();
        }

        Flash::success(trans('dashboard::dashboard.flash.permission.create.success'));

        return redirect()->route('permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (!$permission = $this->permissionRepositoryInterface->getById($id)) {
            Flash::error(trans('dashboard::dashboard.errors.permission.found'));

            return redirect()->route('permissions.index');
        }

        return $this->view('permissions.edit')->with(['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->permissionRepositoryInterface->update($request->all(), $id);
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('permissions.edit', ['id' => $id])
              ->withErrors($e->getErrors())
              ->withInput();
        } catch (PermissionsException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('permissions.index');
        }

        Flash::success(trans('dashboard::dashboard.flash.permission.edit.success'));

        return redirect()->route('permissions.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            $this->permissionRepositoryInterface->delete($id);
        } catch (PermissionsException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('permissions.index');
        }

        Flash::success(trans('dashboard::dashboard.flash.permission.delete.success'));

        return redirect()->route('permissions.index');
    }
}