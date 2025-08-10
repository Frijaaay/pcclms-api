<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Controllers\Api\Books\BookController;

/**
 * Routes for api/v2
*/
Route::prefix('v2')->name('api.v2.')->group(function () {
    /**
     * Routes for api/v2/auth
     */
    Route::prefix('auth')->name('auth.')->group(function () {
        /**
         * Routes that uses AuthController
         */
        Route::controller(AuthController::class)->group(function () {
            Route::post('/login', 'login')->name('login');
            Route::middleware('jwt')->group(function () {
                Route::get('/hydrate', 'hydrate')->name('hydrate');
                Route::post('/logout', 'logout')->name('logout');
            });
        });
    });
    /**
     * Routes for api/v2/users
    */
    Route::prefix('users')->name('users.')->group(function () {
            /**
             * Routes that uses UserController
            */
        Route::controller(UserController::class)->middleware('jwt')->group(function () {
            Route::get('/all', 'all')->name('all');
            Route::post('/', 'store')->name('store');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });
    });
    /**
     * api/v2/books
     */
    Route::prefix('books')->name('books.')->middleware('jwt')->controller(BookController::class)->group(function () {

    });
});



// Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function ()
// {
//     Route::group(['prefix' => 'users', 'as' => 'users.'], function ()
//     {
//         Route::post('/login', [AuthController::class, 'login']);

//         Route::middleware('jwt')->group(function ()
//         {
//             Route::get('/all', [UserController::class, 'index']);

//             Route::get('/me', [UserController::class, 'me']);
//             Route::put('/me', [UserController::class, 'updateMe']);
//             Route::post('/logout', [AuthController::class, 'logout']);

//             Route::get('/librarians', [UserController::class, 'librarians']);
//             Route::post('/librarians', [UserController::class, 'createLibrarian']);
//             Route::get('/borrowers', [UserController::class, 'borrowers']);
//             Route::post('/borrowers', [UserController::class, 'createBorrower']);
//         });
//     });

//     Route::group(['prefix' => 'books', 'as' => 'books.'], function ()
//     {
//         Route::middleware('auth:api')->group(function () {
//             Route::get('/all', [BookController::class, 'index'])->name('all');
//             Route::get('/copies', [BookController::class, 'copies']);
//         });
//     });
// });
