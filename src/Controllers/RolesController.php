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
use Odotmedia\Dashboard\Exceptions\RolesException;

class RolesController extends BaseDashboardController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = $this->roleRepositoryInterface->getAll();

        return $this->view('roles.index')->with(['roles' => $roles]);
    }

    /**
     * Create a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permissions = $this->permissionRepositoryInterface->getAll();

        return $this->view('roles.create')->with(['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function store(Request $request)
    {
        try {
            $this->roleRepositoryInterface->create($request->all());
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('roles.create')
              ->withErrors($e->getErrors())
              ->withInput();
        } catch (RolesException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('roles.create')
              ->withInput();
        }

        Flash::success('Role successfully created.');

        return redirect()->route('roles.index');
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
        if (!$role = $this->roleRepositoryInterface->getById($id)) {
            Flash::error('Role could not be found.');

            return redirect()->route('roles.index');
        }

        $permissions = $this->permissionRepositoryInterface->getAll();

        return $this->view('roles.edit')->with(['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param         $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->roleRepositoryInterface->update($request->all(), $id);
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('roles.edit', ['id' => $id])
              ->withErrors($e->getErrors())
              ->withInput();
        } catch (RolesException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('roles.index');
        }

        Flash::success('Role successfully updated.');

        return redirect()->route('roles.edit', ['id' => $id]);
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
            $this->roleRepositoryInterface->delete($id);
        } catch (RolesException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('roles.index');
        }

        Flash::success('Role successfully deleted.');

        return redirect()->route('roles.index');
    }
}