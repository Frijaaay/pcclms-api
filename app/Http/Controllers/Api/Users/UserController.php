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

    public function __construct(UserServiceInterface $service)
    {
        parent::__construct($service);
    }

    /**
     * Get all librarians
     */
    public function allLibrarians()
    {
        $response = $this->service->getAllLibrarians();
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    /**
     * Get all borrowers
     */
    public function allBorrowers()
    {
        $response = $this->service->getAllBorrowers();
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    /**
     * Create User
     */
    public function store(StoreUserRequest $request)
    {
        $response = $this->service->create($request->validated());
        return $this->handleSuccessResponse($response['data'], $response['message'], 201);
    }

    /**
     * Update User
     */
    public function update(string $id, UpdateUserRequest $request)
    {
        $response = $this->service->update($id, $request->validated());
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    /**
     *  Delete User
     */
    public function delete(string $id, DeleteUserRequest $_)
    {
        $response = $this->service->delete($id);
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    /**
     * Verify user email
     */
    public function verifyEmail(string $id, $token)
    {
        if (!$this->service->email_verification($id, $token)) {
            throw new ExpiredSignedUriException();
        }
        return view('email-verified');
    }
}
