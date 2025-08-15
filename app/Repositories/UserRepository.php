<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\Repositories\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Exception\ExpiredSignedUriException;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Dependency Injection
     */
    private User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
    /**
     * Gets all models that are librarians
     */
    public function selectAllLibrarians()
    {
        return $this->model->where('user_type_id', '=', 2)->orderBy('status')->get();
    }

    /**
     * Gets all models that are borrowers
     */
    public function selectAllBorrowers()
    {
        return $this->model->where('user_type_id', '=', 3)->orderBy('status')->get();
    }
    /**
     * Creates new model in users
     */
    public function createUser(array $data)
    {
        return $this->model->create($data);
    }
    /**
     * Update model in users by id
     */
    public function updateUserById(string $id, array $data)
    {
        $this->model->where('id', $id)->update($data);

        return $this->model->find($id);
    }
    /**
     * Delete model in users by id
     */
    public function deleteUserById(string $id)
    {
        return $this->model->find($id)->delete();
    }
    /**
     * Verify email token
     */
    public function verifyEmailToken(string $id, $email_token)
    {
        $user = $this->model->findOrFail($id);

        if ($user->email_verification_token !== $email_token) {
            throw new ExpiredSignedUriException();
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return $user;
    }
}
