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
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;
use Odotmedia\Dashboard\Exceptions\FormValidationException;
use Odotmedia\Dashboard\Exceptions\PermissionsException;
use Odotmedia\Dashboard\Services\Auth\AuthService;
use Odotmedia\Dashboard\Services\Permission\PermissionService;

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

        Flash::success('Permission successfully created.');

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
            Flash::error('Permission does not exist.');

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

        Flash::success('Permission successfully updated.');

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

        Flash::success('Permission successfully deleted.');

        return redirect()->route('permissions.index');
    }
}