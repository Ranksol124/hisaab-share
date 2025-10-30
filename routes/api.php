<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::post('/register', [ApiController::class,'Register']);
Route::post('/resend-verification', [ApiController::class,'ResendMail']);

Route::post('/forgot-password', [ApiController::class, 'PasswordReset']);
