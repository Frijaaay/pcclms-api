<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * Add New User
     */
    public function create(Request $request)
    {
        return response()->json([
            'message' => 'User created successfully'
        ]);
    }

    /**
     * For Hydration
     */
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if(!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->load('userType');
            return response()->json($user);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Get Librarians
     */
    public function librarians()
    {
        $librarians = User::whereHas('userType', function ($query) {
            $query->where('id', '2');
        })->get();

        return response()->json([
            'librarian' => $librarians,
            'librarian_count' => count($librarians)
        ]);
    }

    /**
     * Get Borrowers
     */
    public function borrowers()
    {
        $borrowers = User::whereHas('userType', function ($query) {
            $query->where('id', '3');
        })->get();

        return response()->json([
            'borrower' => $borrowers,
            'borrower_count' => count($borrowers)
        ]);
    }
}
