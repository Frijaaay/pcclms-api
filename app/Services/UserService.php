<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Mail;

class UserService implements UserServiceInterface
{
    /**
     * Dependency Injection
     */
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all Users
     */
    public function getAllUsers()
    {
        $users = $this->userRepository->selectAllUsers();

        return [
            'librarians' => $users[2] ?? collect(),
            'borrowers' => $users[3] ?? collect()
        ];
    }

    /**
     * Create User
     */
    public function store(array $userData)
    {
        $user = $this->userRepository->createUser($userData);

        $plainPassword = $userData['plain_password'];
        unset($userData['plain_password']);

        /**
         * Send Email to the created user's email
        */

        Mail::to($user->email)->send(new UserCreatedMail(
            $user->name,
            $user->id_number,
            $plainPassword
        ));

        return [
            'message' => 'User created successfully',
            'user' => $user
        ];
    }

    /**
     * Update User
     */
    public function update(int $id, array $updatedUser)
    {
        $user = $this->userRepository->updateUserById($id, $updatedUser);

        return [
            'message' => 'User profile updated successfully',
            'data' => $user
        ];
    }

    /**
     * Delete User
     */
    public function delete(int $id)
    {
        $this->userRepository->deleteUserById($id);

        return [
            'message' => 'User deleted successfully',
        ];
    }
}
