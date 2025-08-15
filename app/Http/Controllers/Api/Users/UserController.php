<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
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
     * Get all librarians
     */
    public function allLibrarians()
    {
        return $this->userService->getAllLibrarians();
    }

    /**
     * Get all borrowers
     */
    public function allBorrowers()
    {
        return $this->userService->getAllBorrowers();
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
    public function update(string $id, UpdateUserRequest $request)
    {
        return $this->userService->update($id, $request->validated());
        // return ['hello' => 'world', 'id' => $id];
    }

    /**
     *  Delete User
     */
    public function delete(string $id, DeleteUserRequest $request)
    {
        return $this->userService->delete($id);
    }
}
