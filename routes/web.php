<?php

use App\Models\User;
use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/mail', function () {
    Mail::to(['2021-102369@rtu.edu.ph'])->send(new UserCreatedMail(
        'Test User',
        '2000-NUMBER',
        'TestPassword123'
    ));

    return 'Mail sent!';
});

Route::get('/email', function () {
    $user = User::where('user_type_id', 1)->first();

    return view('emails.verify_email',
        [
            'id' => $user->id,
            'email_token' => $user->email_verification_token
        ]);
});
