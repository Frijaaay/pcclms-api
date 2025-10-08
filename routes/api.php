<?php

use App\Http\Controllers\Api\Books\ReportController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BorrowedBookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Controllers\Api\Books\BookController;

/**
 * V1 API Endpoints
*/
Route::prefix('v1')->name('api.v1.')->group(function () {
    /**
     * Routes for api/v1/auth endpoint
     */
    Route::prefix('auth')->controller(AuthController::class)->name('auth.')->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/refresh', 'refresh')->name('refresh');
        Route::get('/hydrate', 'hydrate')->name('hydrate');
        Route::middleware('jwt')->group(function () {
        });
    });
    /**
     * Routes for api/v1/users
    */
    Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
        Route::middleware('jwt')->group(function () {
            Route::get('/', 'all')->name('all_users');
            Route::post('/', 'store')->name('store_user');
            Route::get('/librarians', 'allLibrarians')->name('all_librarians');
            Route::get('/borrowers', 'allBorrowers')->name('all_borrowers');
            Route::get('/{id}', 'show')->whereUuid('id')->name('show_user');
            Route::post('/update/{id}', 'update')->whereUuid('id')->name('update');
            Route::delete('/delete/{id}', 'delete')->whereUuid('id')->name('delete');
        });
        /** Email Verification Route */
        Route::get('/email/verify/{id}/{email_token}', 'verifyEmail')->whereUuid('id')->name('email.verification');
    });
    /**
     * Routes for api/v1/books
     */
    Route::prefix('books')->name('books.')->middleware('jwt')->controller(BookController::class)->group(function () {
        Route::get('/', 'all')->name('all');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/copies', 'showBookCopies')->name('showBookCopies');
        Route::post('/', 'store')->name('store');
        Route::post('/{id}/add', 'storeBookCopy')->name('storeBookCopy');
        Route::post('/update/{id}', 'update')->name('update');
        Route::post('/{id}/update/{copy_id}', 'updateBookCopy')->name('updateBookCopy');
        Route::delete('/delete/{id}', 'delete')->name('delete');

        Route::post('/borrow', 'borrowBook')->name('borrowBook');
        Route::post('/return', 'returnBook')->name('returnBook');
    });

    /**
     * api/v1/reports
     */
    Route::prefix('reports')->name('reports.')->middleware('jwt')->controller(ReportController::class)->group(function () {
        Route::get('/all', 'all')->name('allReports');
        Route::get('/{id}', 'show')->name('showReportById');
        Route::prefix('borrowed')->name('borrowed.')->group(function () {
            Route::get('/all', 'allBorrowed')->name('allBorrowed');
            Route::get('/{id}', 'showBorrowedById')->name('showBorrowedById');
            Route::get('/user/{id}', 'showByBorrowerId')->name('showBorrowedByBorrowerId');
        });

        Route::prefix('returned')->name('returned.')->group(function () {
            Route::get('/all', 'allReturned')->name('allReturned');
            Route::get('/{id}', 'showReturnedById')->name('showReturnedById');
            Route::get('/user/{id}', 'showByReturnerId')->name('showReturnedByReturnerId');
        });
    });
});
