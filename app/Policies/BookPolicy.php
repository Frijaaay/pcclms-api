<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manage_book(User $authUser)
    {
        return in_array($authUser->user_type_id, [1, 2]);
    }
    // public function storeBook(User $authUser)
    // {
    //     return in_array($authUser->user_type_id, [1, 2]);
    // }

    // public function updateBook(User $authUser)
    // {
    //     return in_array($authUser->user_type_id, [1, 2]);
    // }

    // public function deleteBook(User $authUser)
    // {
    //     return in_array($authUser->user_type_id, [1, 2]);
    // }
}
