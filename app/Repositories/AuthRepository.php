<?php

namespace App\Repositories;

use App\Contracts\Repositories\AuthRepositoryInterface;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


}
