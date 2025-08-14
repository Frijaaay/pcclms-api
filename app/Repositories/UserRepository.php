<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

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
    public function updateUserById(int $id, array $data)
    {
        $this->model->where('id', $id)->update($data);

        return $this->model->find($id);
    }
    /**
     * Delete model in users by id
     */
    public function deleteUserById(int $id)
    {
        return $this->model->find($id)->delete();
    }
}
