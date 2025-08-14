<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Controllers\Api\Books\BookController;

/**
 * Routes for api/v1
*/
Route::prefix('v1')->name('api.v1.')->group(function () {
    /**
     * Routes for api/v1/auth
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
     * Routes for api/v1/users
    */
    Route::prefix('users')->name('users.')->group(function () {
        Route::controller(UserController::class)->middleware('jwt')->group(function () {
            Route::get('/librarians', 'allLibrarians')->name('allLibrarians');
            Route::get('/borrowers', 'allBorrowers')->name('allBorrowers');
            Route::post('/', 'store')->name('store');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });
    });
    /**
     * api/v1/books
     */
    Route::prefix('books')->name('books.')->middleware('jwt')->controller(BookController::class)->group(function () {
        Route::get('/all', 'all')->name('all');
        Route::post('/', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
});
