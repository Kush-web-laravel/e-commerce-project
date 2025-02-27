<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required'
        ]);

        $otp = rand(1000000, 9999999);
        $expiresAt = now()->addMinutes(10);

        // Check if the user with the given mobile number exists
        $user = User::where('mobile_number', $request->mobile_number)->first();

        if ($user) {
            // Update the existing user's OTP and expiration time
            $user->update([
                'otp' => $otp,
                'otp_expires_at' => $expiresAt,
            ]);
        } else {
            // Create a new user record with the mobile number and OTP
            User::create([
                'mobile_number' => $request->mobile_number,
                'otp' => $otp,
                'otp_expires_at' => $expiresAt,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent successfully. Expires at ' . $expiresAt,
            'otp' => $otp,
            'current_time' => now(),
            'otp_expires_at' => $expiresAt,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required',
            'otp' => 'required',
        ]);

        $user = User::where('mobile_number', $request->mobile_number)
                    ->where('otp', $request->otp)
                    ->where('otp_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid OTP or OTP expired']);
        }

        $user->update(['otp' => null, 'otp_expires_at' => null]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'You have logged in successfully',
            'token' => $token,
        ]);
    }


    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);

        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'message' => 'Profile updated successfully',
        ]);
    }

    
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
    }

}
