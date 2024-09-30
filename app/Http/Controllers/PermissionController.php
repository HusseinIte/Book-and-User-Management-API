<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use App\Service\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $permissions = $this->permissionService->getAllPermissions();
            return $this->sendRespons($permissions, 'Permissions retrieve successfully');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        try {
            $validated = $request->validated();
            $permission = $this->permissionService->createPermission($validated);
            return $this->sendRespons($permission, 'Permission created successfully');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($permissionId)
    {
        try {
            $permission = $this->permissionService->showPermission($permissionId);
            return $this->sendRespons($permission, 'Permission retieve successfully');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, $permissionId)
    {
        try {
            $validated = $request->validated();
            $permission = $this->permissionService->updatePermission($validated, $permissionId);
            return $this->sendRespons($permission, 'Permission updated successfully');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($permissionId)
    {
        try {
            $this->permissionService->deletePermission($permissionId);
            return $this->sendRespons(null, 'Permission deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
