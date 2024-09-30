<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ############        Auth Routes    ###################
Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
});
// ############       User Routes    ###################
Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::post('assign-user-roles/{userId}', [UserController::class, 'assignUserRoles']);
});

// ############       Book Routes    ###################
Route::apiResource('books', BookController::class);

// ############      Category Routes    ###################
Route::apiResource('categories', CategoryController::class);
Route::get('categories/{categoryId}/books', [BookController::class, 'indexByCategory']);

// ############          Role Routes    ###################
Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::post('assign-role-permissions/{roleId}', [RoleController::class, 'assignRolePermissions']);
});



// ############        Permission Routes    ###############
Route::apiResource('permissions', PermissionController::class)->middleware(['auth:api', 'role:Admin']);
