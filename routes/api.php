<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\BookController;

/**
 * Routes for api/v2/users/
*/
Route::prefix('v2')->group(function () {
    Route::middleware('jwt')->group(function () {
    });
        Route::prefix('users')->middleware('jwt')->controller(UserController::class)->group(function () {
            Route::get('/all', 'all')->name('api.v2.users.all');
            Route::post('/', 'store')->name('api.v2.users.store');
    });
});



Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function ()
{
    Route::group(['prefix' => 'users', 'as' => 'users.'], function ()
    {
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('jwt')->group(function ()
        {
            Route::get('/all', [UserController::class, 'index']);

            Route::get('/me', [UserController::class, 'me']);
            Route::put('/me', [UserController::class, 'updateMe']);
            Route::post('/logout', [AuthController::class, 'logout']);

            Route::get('/librarians', [UserController::class, 'librarians']);
            Route::post('/librarians', [UserController::class, 'createLibrarian']);
            Route::get('/borrowers', [UserController::class, 'borrowers']);
            Route::post('/borrowers', [UserController::class, 'createBorrower']);
        });
    });

    Route::group(['prefix' => 'books', 'as' => 'books.'], function ()
    {
        Route::middleware('auth:api')->group(function () {
            Route::get('/all', [BookController::class, 'index']);
            Route::get('/copies', [BookController::class, 'copies']);
        });
    });
});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
