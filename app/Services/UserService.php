<?php

namespace App\Services;

use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Services\UserServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;

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
     * Get all librarians
     */
    public function getAllLibrarians()
    {
        $librarians = $this->userRepository->selectAllLibrarians();

        return [
            'librarian_count' => count($librarians),
            'librarians' => $librarians
        ];
    }

    /**
     * Get all borrowers
     */
    public function getAllBorrowers()
    {
        $borrowers = $this->userRepository->selectAllBorrowers();

        return [
            'borrower_count' => count($borrowers),
            'borrowers' => $borrowers
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
    public function update(string $id, array $updatedUser)
    {
        $user = $this->userRepository->updateUserById($id, $updatedUser);

        return [
            'message' => 'User profile updated successfully',
            'user' => $user
        ];
    }

    /**
     * Delete User
     */
    public function delete(string $id)
    {
        $this->userRepository->deleteUserById($id);

        return [
            'message' => 'User deleted successfully',
        ];
    }
}
