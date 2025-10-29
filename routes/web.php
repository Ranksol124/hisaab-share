<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::middleware(['auth', 'signed'])->get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/admin');
})->name('verification.verify');

Route::post('/admin/email-verification/resend', function () {
    $user = Auth::user();

    if ($user && !$user->hasVerifiedEmail()) {
        $user->sendEmailVerificationNotification(); // actually sends the email
        return back()->with('success', 'Verification email has been resent.');
    }

    return back()->with('danger', 'Your email is already verified.');
})->middleware(['auth'])->name('filament.admin.verification.resend');



Route::post('/admin/email/verification-notification', function (Request $request) {
    $user = auth('admin')->user(); // use the admin guard

    if ($user) {
        Notification::send($user, new VerifyEmail());
        return back()->with('success', 'Verification link sent!');
    }

    return back()->with('error', 'Unable to resend verification link.');
})->name('filament.admin.verification.send');
