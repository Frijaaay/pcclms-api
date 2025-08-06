<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Fetch all Users
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'user' => $users
        ], 200);
    }
    /**
     * For Hydration
     */
    public function me()
    {
        try {
            $user = auth('api')->user();

            if(!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

/** @var \App\Models\User $user */
            $user->load('userType');
            return response()->json($user);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    /**
     * Update Currently Logged In User
     */
    public function updateMe(Request $request)
    {
        $user = auth('api')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'department' => 'required|string|max:100',
            'type' => 'required|string|max:100',
        ]);

/** @var \App\Models\User $user */
        $user->update($validated);
        // $user = $user->fresh();

        return response()->json($user->fresh());
    }

    /**
     * Get Librarians
     */
    public function librarians()
    {
        $librarians = User::where('user_type_id', 2)
        ->orderByRaw("FIELD(status, 'active', 'inactive')")
        ->orderByDesc('created_at')
        ->get();

        return response()->json([
            'librarian' => $librarians,
            'librarian_count' => count($librarians)
        ]);
    }
    /**
     * Create Librarian
     */
    public function createLibrarian(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'id_number' => 'required|string|max:50|unique:users,id_number',
            'type' => 'required|string|max:100',
            'department' => 'required|string|max:100',
        ]);

        $validated['password'] = bcrypt(Str::random(10));
        $validated['user_type_id'] = 2; //2 is the ID for Librarian
        $validated['status'] = 'Inactive'; //Sets to Inactive

        $librarian = User::create($validated);

        return response()->json([
            'librarian' => $librarian->fresh(),
            'librarian_count' => User::where('user_type_id', 2)->count()
        ], 201);
    }
    /**
     * Get Borrowers
     */
    public function borrowers()
    {
        $borrowers = User::where('user_type_id', 3)
        ->orderByRaw("FIELD(status, 'active', 'inactive')")
        ->orderByDesc('created_at')
        ->get();

        return response()->json([
            'borrowers' => $borrowers,
            'borrower_count' => count($borrowers)
        ]);
    }
    /**
     * Create Borrower
     */
    public function createBorrower(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'id_number' => 'required|string|max:50|unique:users,id_number',
            'type' => 'required|string|max:100',
            'department' => 'required|string|max:100',
        ]);

        $validated['password'] = bcrypt(Str::random(10));
        $validated['user_type_id'] = 3; //3 is the ID for Borrower
        $validated['status'] = 'Inactive'; //Sets to Inactive

        $borrower = User::create($validated);

        return response()->json([
            'borrower' => $borrower->fresh(),
            'borrower_count' => User::where('user_type_id', 3)->count()
        ], 201);
    }
}
