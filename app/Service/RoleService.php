<?php

namespace App\Service;

use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\FuncCall;

class RoleService
{
    public function createRole(array $data)
    {
        try {
            $role = Role::create([
                'name' => $data['name'],
                'description' => isset($data['description']) ? $data['description'] : null
            ]);
            Log::info("role created successfully");
            return $role;
        } catch (QueryException $e) {
            Log::error("Database query error while creating role: " . $e->getMessage());
            throw new \Exception('Database query error while creating role');
        } catch (\Exception $e) {
            Log::error('An unexpected error while creating role: ' . $e->getMessage());
            throw new \Exception('An expected error while creating role');
        }
    }
    public function getAllRoles()
    {
        try {
            $roles = Role::all();
            if ($roles->isEmpty()) {
                throw new \Exception('No roles found.');
            }
            return $roles;
        } catch (QueryException $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            throw new \Exception('Failed to retrieve roles from the database.');
        } catch (\Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function showRole($id)
    {
        try {
            $role = Role::findOrFail($id);
            return $role;
        } catch (ModelNotFoundException $e) {
            Log::error("Role with id $id not found: " . $e->getMessage());
            throw new \Exception('Role Not Found');
        } catch (QueryException $e) {
            Log::error("Database query error for role id $id: " . $e->getMessage());
            throw new \Exception('Database query error while retrieving the role.');
        } catch (\Exception $e) {
            Log::error("An unexepted error occurred while retrieving role id $id: " . $e->getMessage());
            throw new \Exception('An unexepted error occurred while retriving the role.');
        }
    }

    public function updateRole(array $data, $roleId)
    {
        try {
            $role = Role::findOrFail($roleId);
            $role->update([
                'name'    => isset($data['name'])  ? $data['name'] : $role->name,
                'description'   => isset($data['description']) ? $data['description'] : $role->description
            ]);
            Log::info("Role with id $roleId successfully updated");
            return $role;
        } catch (ModelNotFoundException $e) {
            Log::error("Role with id $roleId not found for update: " . $e->getMessage());
            throw new ModelNotFoundException('Role Not Found');
        } catch (QueryException $e) {
            Log::error("Database query error for updating role id $roleId: " . $e->getMessage());
            throw new \Exception('Database query error for updating role');
        } catch (\Exception $e) {
            Log::error("An unexpected error while updating role id $roleId: " . $e->getMessage());
            throw new \Exception('An expected error while updating role');
        }
    }

    public function deleteRole($roleId)
    {
        try {
            $role = Role::findOrFail($roleId);
            $role->delete();
            Log::info("Role with id $roleId deleted successfully.");
        } catch (ModelNotFoundException $e) {
            Log::error("Role with id $roleId not found for deleted: " . $e->getMessage());
            throw new \Exception('Role not found');
        } catch (QueryException $e) {
            Log::error("Database query error while deleting role id $roleId: " . $e->getMessage());
            throw new \Exception("Database query error while deleting role");
        } catch (\Exception $e) {
            Log::error("An unexpected error while deleting role id $roleId: " . $e->getMessage());
            throw new \Exception('An expected error while deleting role.');
        }
    }

    public function assignRolePermessions(array $data,$roleId){
        try {
            $role = Role::findOrFail($roleId);
            $role->permissions()->attach($data['permission_ids']);
            Log::info("Permissions have been assigned to the role id $roleId successfully.");
        } catch (ModelNotFoundException $e) {
            Log::error("Role with id $roleId not found to assigne permissions: " . $e->getMessage());
            throw new \Exception('Role not found');
        } catch (\Exception $e) {
            Log::error("An unexpected error while assign permission ids to the role id $roleId: " . $e->getMessage());
            throw new \Exception('An expected error while assign permissions to role.');
        }
    }
}
