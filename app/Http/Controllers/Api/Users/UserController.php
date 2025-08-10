<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Dependency Injection
     */
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Get all User
     */
    public function all()
    {
        return $this->userService->getAllUsers();
    }

    /**
     * Create User
     */
    public function store(StoreUserRequest $request)
    {
        return $this->userService->store($request->validated());
    }

    /**
     * Update User
     */
    public function update(int $id, UpdateUserRequest $request)
    {
        return $this->userService->update($id, $request->validated());
    }

    /**
     *  Delete User
     */
    public function delete(int $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $this->authorize('delete', $user);
        return $this->userService->delete($id);
    }
}
