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

    return view('emails.user_created',
        [
            'name' => $user->name,
            'email' => $user->email,
            'id_number' => $user->id_number,
            'plainPassword' => 'Test Password'
        ]);
});
