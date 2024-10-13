<?php

namespace App\Service;

use App\Http\Requests\StoreUserRequest;
use App\Models\Book;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use PDO;

class UserService
{
    public function createUser(array $data)
    {
        try {
            return User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $data['password'],
            ]);
        } catch (QueryException $e) {
            Log::error('Error while creating user: ' . $e->getMessage());
            throw new Exception('Failed to create user due to a database error');
        }
    }

    public function getAllUsers()
    {
        try {
            $users = User::all();
            if ($users->isEmpty()) {
                throw new \Exception('No users found.');
            }
            return $users;
        } catch (QueryException $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            throw new \Exception('Failed to retrieve users from the database.');
        } catch (Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function showUser($id)
    {
        try {
            $user = User::findOrFail($id);
            return $user;
        } catch (ModelNotFoundException $e) {
            Log::error("User with id $id not found: " . $e->getMessage());
            throw new Exception('User Not Found');
        } catch (QueryException $e) {
            Log::error("Database query error for user id $id: " . $e->getMessage());
            throw new Exception('Database query error while retrieving the user.');
        } catch (Exception $e) {
            Log::error("An unexepted error occurred while retrieving user id $id: " . $e->getMessage());
            throw new Exception('An unexepted error occurred while retriving the user.');
        }
    }

    public function updateUser(array $data, $userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->update([
                'name'    => isset($data['name'])  ? $data['name'] : $user->name,
                'email'   => isset($data['email']) ? $data['email'] : $user->email,
                'password' => isset($data['password']) ? $data['password'] : $user->password,
            ]);
            Log::info("User with id $userId successfully updated");
            return $user;
        } catch (ModelNotFoundException $e) {
            Log::error("User with id $userId not found for update: " . $e->getMessage());
            throw new ModelNotFoundException('User Not Found');
        } catch (QueryException $e) {
            Log::error("Database query error for updating user id $userId: " . $e->getMessage());
            throw new Exception('Database query error for updating user');
        } catch (Exception $e) {
            Log::error("An unexpected error while updating user id $userId: " . $e->getMessage());
            throw new Exception('An expected error while updating user');
        }
    }

    public function deleteUser($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();
            Log::info("User with id $userId deleted successfully.");
        } catch (ModelNotFoundException $e) {
            Log::error("User with id $userId not found for deleted: " . $e->getMessage());
            throw new Exception('User not found');
        } catch (QueryException $e) {
            Log::error("Database query error while deleting user id $userId: " . $e->getMessage());
            throw new Exception("Database query error while deleting user");
        } catch (Exception $e) {
            Log::error("An unexpected error while deleting user id $userId: " . $e->getMessage());
            throw new Exception('An expected error while deleting user.');
        }
    }

    public function assignUserRoles(array $data, $userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->roles()->attach($data['role_ids']);
            Log::info("Roles have been assigned to the user id $userId successfully.");
        } catch (ModelNotFoundException $e) {
            Log::error("User with id $userId not found to assigne roles: " . $e->getMessage());
            throw new Exception('User not found');
        } catch (Exception $e) {
            Log::error("An unexpected error while assign role ids to user id $userId: " . $e->getMessage());
            throw new Exception('An expected error while assign roles to user.');
        }
    }
}
