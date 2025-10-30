<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Verified;


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = User::findOrFail($request->route('id'));


    if (!$request->hasValidSignature()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or expired verification link.',
        ], 403);
    }


    if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid verification hash.',
        ], 403);
    }


    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    return view('emails.verified', [
        'user' => $user,
        'message' => 'Your email has been verified successfully.',
    ]);
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
