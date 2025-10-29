<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
public function Register(Request $request)
{
    try {
   
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|max:55',
            'MobileNo' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $data = $request->all();

    

        $registerPage = new Register();
        $user = $registerPage->handleRegistration($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email ?? null,
                'mobileNo' => $user->mobileNo ?? null,
            ],
            'token' => $token,
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
        ], 422);
    } catch (\Throwable $e) {
        Log::error('API Register Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong during registration.',
        ], 500);
    }
}


    // public function Register(Request $request)
    // {

    //     try {

    //         $request->validate([
    //             'name' => 'required|string',
    //             'email' => 'required|string|max:255',
    //             'password' => 'required|string|confirmed|min:8',
    //         ]);
    //         $data = $request->all();
    //         $data['identifier'] = $request->email;
    //         $registerPage = new Register();
    //         $user = $registerPage->handleRegistration($data); 



    //         $token = $user->createToken('auth_token')->plainTextToken;

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'User registered successfully.',
    //             'user' => [
    //                 'id' => $user->id,
    //                 'name' => $user->name,
    //                 'email' => $user->email,
    //                 'mobileNo' => $user->mobileNo ?? null,
    //             ],
    //             'token' => $token,
    //         ], 201);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $e->errors(),
    //         ], 422);
    //     } catch (\Throwable $e) {
    //         Log::error('API Register Error: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Something went wrong during registration.',
    //         ], 500);
    //     }
    // }










public function ResendMail(Request $request)
{
    $request->validate([
        'id' => 'required', 
        'email' => 'required|email',
    ]);

    $user = User::where('id', $request->id)
    ->orWhere('email', $request->id)
    ->orWhere('mobileNo', $request->id)
    ->first();


    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    if ($user->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified'], 400);
    }

    if ($user->email !== $request->email) {
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();
    }


    $user->sendEmailVerificationNotification();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    return response()->json([
        'message' => 'Verification email sent.',
        'verification_url' => $verificationUrl,
    ]);
}






}
