<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\AssignRolePermissionsRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Service\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = $this->roleService->getAllRoles();
            return $this->sendRespons($roles, 'Roles retrieve successfully');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            $validated = $request->validated();
            $role = $this->roleService->createRole($validated);
            return $this->sendRespons($role, 'Role created successfully');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($roleId)
    {
        try {
            $role = $this->roleService->showRole($roleId);
            return $this->sendRespons($role, 'role retieve successfully');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, $roleId)
    {
        try {
            $validated = $request->validated();
            $role = $this->roleService->updateRole($validated, $roleId);
            return $this->sendRespons($role, 'Role updated successfully');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($roleId)
    {
        try {
            $this->roleService->deleteRole($roleId);
            return $this->sendRespons(null, 'role deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function assignRolePermissions(AssignRolePermissionsRequest $request, $roleId)
    {
        try {
            $validated = $request->validated();
            $this->roleService->assignRolePermessions($validated, $roleId);
            return $this->sendRespons(null, 'Permissions have been assigned to the role successfully.');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage(), 400);
        }
    }
}
