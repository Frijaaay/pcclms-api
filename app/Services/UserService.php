<?php

namespace App\Services;

use App\Mail\UserCreatedMail;
use App\Mail\VerifyUserEmail;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Services\UserServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;

class UserService extends BaseService implements UserServiceInterface
{

    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get all librarians
     */
    public function getAllLibrarians()
    {
        return $this->serviceArrayReturn($this->repository->findAllLibrarians());
    }

    /**
     * Get all borrowers
     */
    public function getAllBorrowers()
    {
        return $this->serviceArrayReturn($this->repository->findAllBorrowers());
    }

    /**
     * Create User
     */
    public function create(array $data): Array
    {
        $user = $this->repository->store($data);

        $plainPassword = $data['plain_password'];
        unset($data['plain_password']);

        /** Send Welcome Email */
        Mail::to($user->email)->send(new UserCreatedMail(
            $user->name,
            $user->id_number,
            $plainPassword
        ));
        /** Send Verify Email */
        Mail::to($user->email)->send(new VerifyUserEmail($user->id, $user->email_verification_token));

        return $this->serviceArrayReturn($user, 'User created successfully');
    }

    /**
     * Email Verification
     */
    public function email_verification(string $id, $email_token)
    {
        $user = $this->repository->validateEmailToken($id, $email_token);
        if (!$user) {
            throw new \ErrorException('Something went wrong', 412);
        }
        return ['message' => 'Email Verified Successfully'];
    }
}
