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
     * All Method used by Controller
     */
    public function all()
    {
        return $this->userRepository->all();
    }

    /**
     * Store Method used by Controller
    */
    public function store(array $userData)
    {
        $user = $this->userRepository->create($userData);

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

        return $user;

        // return $this->userRepository->create($userData);
    }
}
