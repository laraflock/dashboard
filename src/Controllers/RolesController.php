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
use Odotmedia\Dashboard\Services\Auth\AuthService;
use Odotmedia\Dashboard\Services\Permission\PermissionService;
use Odotmedia\Dashboard\Services\Role\RoleService;

class RolesController extends BaseDashboardController
{
    /**
     * Auth service instance.
     *
     * @var \Odotmedia\Dashboard\Services\Auth\AuthService
     */
    protected $authService;

    /**
     * Permission service instance.
     *
     * @var \Odotmedia\Dashboard\Services\Permission\PermissionService
     */
    protected $permissionService;

    /**
     * Role service instance.
     *
     * @var \Odotmedia\Dashboard\Services\Role\RoleService
     */
    protected $roleService;

    /**
     * The constructor.
     *
     * @param \Odotmedia\Dashboard\Services\Auth\AuthService             $authService
     * @param \Odotmedia\Dashboard\Services\Permission\PermissionService $permissionService
     * @param \Odotmedia\Dashboard\Services\Role\RoleService             $roleService
     */
    public function __construct(AuthService $authService, PermissionService $permissionService, RoleService $roleService)
    {
        $this->authService = $authService;
        $this->roleService       = $roleService;
        $this->permissionService = $permissionService;

        parent::__construct($authService);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = $this->roleService->getAll();

        return $this->view('roles.index')->with(['roles' => $roles]);
    }

    /**
     * Create a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permissions = $this->permissionService->getAll();

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
            $this->roleService->create($request->all());
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
        if (!$role = $this->roleService->getById($id)) {
            Flash::error('Role does not exist.');

            return redirect()->route('roles.index');
        }

        $permissions = $this->permissionService->getAll();

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
            $this->roleService->update($request->all(), $id);
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
            $this->roleService->delete($id);
        } catch (RolesException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('roles.index');
        }

        Flash::success('Role successfully deleted.');

        return redirect()->route('roles.index');
    }
}