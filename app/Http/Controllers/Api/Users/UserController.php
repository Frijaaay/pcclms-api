<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Exception\ExpiredSignedUriException;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
      * Constructor property promotion
      */
    public function __construct(private UserServiceInterface $userService) {}

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
    }

    /**
     *  Delete User
     */
    public function delete(string $id, DeleteUserRequest $_)
    {
        return $this->userService->delete($id);
    }

    public function verifyEmail(string $id, $token)
    {
        if (!$this->userService->email_verification($id, $token)) {
            throw new ExpiredSignedUriException();
        }
        return view('email-verified');
    }
}
