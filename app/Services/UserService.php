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

    public function getAllAdmins()
    {
        $data = $this->repository->findAllAdmins();
        $data = $data->where('id', '!=', auth()->id());
        return $this->serviceArrayReturn($data);
    }
    /**
     * Get all librarians
     */
    public function getAllLibrarians()
    {
        $data = $this->repository->findAllLibrarians();
        $data = $data->where('id', '!=', auth()->id());
        return $this->serviceArrayReturn($data);
    }

    /**
     * Get all borrowers
     */
    public function getAllBorrowers()
    {
        $data = $this->repository->findAllBorrowers();
        $data = $data->where('id', '!=', auth()->id());
        return $this->serviceArrayReturn($data);
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
     * Updates user
     */
        public function update(mixed $id, array $data): Array
    {
        $user = $this->repository->update($id, $data);
        $user->load('userType');
        return $this->serviceArrayReturn($user, "Update success");
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
