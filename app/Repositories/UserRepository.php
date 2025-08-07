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
    public function all()
    {
        return $this->model->all();
    }
    /**
     * Creates new model in users
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
