<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AssignUserRolesRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Service\UserService;
use Exception;
use Illuminate\Http\Request;
use PDO;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            return $this->sendRespons($users, 'Users retrieved successfully');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = $this->userService->createUser($validated);
            return $this->sendRespons($user, 'User created successfully');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $user = $this->userService->showUser($id);
            return $this->sendRespons($user, 'user has been retrieved successfully');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $validated = $request->validated();
            $user = $this->userService->updateUser($validated, $id);
            return $this->sendRespons($user, 'user updated successfully');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->userService->deleteUser($id);
            return $this->sendRespons(null, 'user deleted successfully.');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 400);
        }
    }

    public function assignUserRoles(AssignUserRolesRequest $request, int $userId)
    {
        try {
            $validated = $request->validated();
            $this->userService->assignUserRoles($validated, $userId);
            return $this->sendRespons(null, 'Roles have been assigned to the user successfully.');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 400);
        }
    }
}
