<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\Repositories\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Exception\ExpiredSignedUriException;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Gets all models that are librarians
     */
    public function findAllLibrarians()
    {
        return $this->model->where('user_type_id', '=', 2)->orderBy('status')->get();
    }

    /**
     * Gets all models that are borrowers
     */
    public function findAllBorrowers()
    {
        return $this->model->where('user_type_id', '=', 3)->orderBy('status')->get();
    }

    /**
     * Verify email token
     */
    public function validateEmailToken(string $id, $email_token)
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

    public function findBorrowedBooks(string $id)
    {
        return $this->model->findOrFail($id)->borrowedBooks;
    }
}
