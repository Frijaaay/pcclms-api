<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Store Policy
    */
    public function store(User $authUser, User $newUser)
    {
        $role = $authUser->user_type_id;
        $allowCreate = $newUser->user_type_id;

        return match ($role) {
            1 => in_array($allowCreate, [1, 2, 3]),
            2 => $allowCreate === 3,
            default => false,
        };
    }

    /**
     * Update policy
     */
    public function update(User $authUser, User $updateUser)
    {
        $role = $authUser->user_type_id;
        $targetUserType = $updateUser->user_type_id;

        $isSelfUpdate = $authUser->id === $updateUser->id;

        return match ($role) {
            1 => $isSelfUpdate || in_array($targetUserType, [2, 3]),
            2 => ($isSelfUpdate || $targetUserType === 3),
            3 => $isSelfUpdate,
            default => false,
        };
    }
    public function delete(User $authUser, User $targetUser)
    {
        $role = $authUser->user_type_id;
        $targetUserType = $targetUser->user_type_id;

        return match ($role) {
            1 => in_array($targetUserType, [2, 3]),
            2 => $targetUserType === 3,
            default => false,
        };
    }
}
