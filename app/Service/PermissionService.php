<?php

namespace App\Service;

use App\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class PermissionService
{
    public function createPermission(array $data)
    {
        try {
            $permission = Permission::create([
                'name' => $data['name'],
                'description' => isset($data['description']) ? $data['description'] : null
            ]);
            Log::info("permission created successfully");
            return $permission;
        } catch (QueryException $e) {
            Log::error("Database query error while creating permission: " . $e->getMessage());
            throw new \Exception('Database query error while creating permission');
        } catch (\Exception $e) {
            Log::error('An unexpected error while creating permission: ' . $e->getMessage());
            throw new \Exception('An expected error while creating permission');
        }
    }
    public function getAllPermissions()
    {
        try {
            $permissions = Permission::all();
            if ($permissions->isEmpty()) {
                throw new \Exception('No permissions found.');
            }
            return $permissions;
        } catch (QueryException $e) {
            Log::error('Error fetching permissions: ' . $e->getMessage());
            throw new \Exception('Failed to retrieve permissions from the database.');
        } catch (\Exception $e) {
            Log::error('Error fetching permissions: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function showPermission($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            return $permission;
        } catch (ModelNotFoundException $e) {
            Log::error("Permission with id $id not found: " . $e->getMessage());
            throw new \Exception('Permission Not Found');
        } catch (QueryException $e) {
            Log::error("Database query error for permission id $id: " . $e->getMessage());
            throw new \Exception('Database query error while retrieving the permission.');
        } catch (\Exception $e) {
            Log::error("An unexepted error occurred while retrieving permission id $id: " . $e->getMessage());
            throw new \Exception('An unexepted error occurred while retriving the permission.');
        }
    }

    public function updatePermission(array $data, $permissionId)
    {
        try {
            $permission = Permission::findOrFail($permissionId);
            $permission->update([
                'name'    => isset($data['name'])  ? $data['name'] : $permission->name,
                'description'   => isset($data['description']) ? $data['description'] : $permission->description
            ]);
            Log::info("Permission with id $permissionId successfully updated");
            return $permission;
        } catch (ModelNotFoundException $e) {
            Log::error("Permission with id $permissionId not found for update: " . $e->getMessage());
            throw new ModelNotFoundException('Permission Not Found');
        } catch (QueryException $e) {
            Log::error("Database query error for updating permission id $permissionId: " . $e->getMessage());
            throw new \Exception('Database query error for updating permission');
        } catch (\Exception $e) {
            Log::error("An unexpected error while updating permission id $permissionId: " . $e->getMessage());
            throw new \Exception('An expected error while updating permission');
        }
    }

    public function deletePermission($permissionId)
    {
        try {
            $permission = Permission::findOrFail($permissionId);
            $permission->delete();
            Log::info("Permission with id $permissionId deleted successfully.");
        } catch (ModelNotFoundException $e) {
            Log::error("Permission with id $permissionId not found for deleted: " . $e->getMessage());
            throw new \Exception('Permission not found');
        } catch (QueryException $e) {
            Log::error("Database query error while deleting permission id $permissionId: " . $e->getMessage());
            throw new \Exception("Database query error while deleting permission");
        } catch (\Exception $e) {
            Log::error("An unexpected error while deleting permission id $permissionId: " . $e->getMessage());
            throw new \Exception('An expected error while deleting permission.');
        }
    }
}
