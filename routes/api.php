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
            Route::post('/refresh', 'refresh')->name('refresh');
            Route::middleware('jwt')->group(function () {
                Route::get('/hydrate', 'hydrate')->name('hydrate');
                Route::post('/logout', 'logout')->name('logout');
            });
        });
    });
    /**
     * Routes for api/v1/users
    */
    Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
        /**
        * Email Verification Routes
        */
        Route::get('/email/verify/{id}/{email_token}', 'verifyEmail')->whereUuid('id')->name('email.verification');
        Route::middleware('jwt')->group(function () {
            Route::get('/librarians', 'allLibrarians')->name('allLibrarians');
            Route::get('/borrowers', 'allBorrowers')->name('allBorrowers');
            Route::post('/', 'store')->name('store');
            Route::post('/update/{id}', 'update')->whereUuid('id')->name('update');
            Route::delete('/delete/{id}', 'delete')->whereUuid('id')->name('delete');
        });
    });
    /**
     * api/v1/books
     */
    Route::prefix('books')->name('books.')->middleware('jwt')->controller(BookController::class)->group(function () {
        Route::get('/all', 'all')->name('all');
        Route::post('/', 'store')->name('store');
        Route::post('/{id}/add', 'addNewCopy')->name('addNewCopy');
        Route::post('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
});
