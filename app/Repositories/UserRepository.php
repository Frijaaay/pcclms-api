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
     * Gets all models in users
     */
    public function selectAllUsers()
    {
        return $this->model->whereNot('user_type_id', '=', 1)->get()->groupBy('user_type_id');
    }
    /**
     * Creates new model in users
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    /**
     * Update model in users by id
     */
    public function update(int $id, array $data)
    {
        //
    }
    /**
     * Delete model in users by id
     */
    public function delete(int $id)
    {
        //
    }
}
