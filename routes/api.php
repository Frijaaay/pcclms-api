<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\BookController;

Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function ()
{
    Route::group(['prefix' => 'users', 'as' => 'users.'], function ()
    {
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('jwt')->group(function ()
        {
            Route::get('/me', [UserController::class, 'me']);
            Route::post('/logout', [AuthController::class, 'logout']);

            Route::get('/profile', [UserController::class, 'profile']);
            Route::get('/librarians', [UserController::class, 'librarians']);
            Route::post('/librarians', [UserController::class, 'create']);
            Route::get('/borrowers', [UserController::class, 'borrowers']);
        });
    });

    Route::group(['prefix' => 'books', 'as' => 'books.'], function ()
    {
        Route::middleware('auth:api')->group(function () {
            Route::get('/all', [BookController::class, 'books']);
            Route::get('/copies', [BookController::class, 'copies']);
        });
    });
});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
