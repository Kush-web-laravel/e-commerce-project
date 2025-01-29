<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\MailService;

class AuthController extends Controller
{
    //
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }
    public function register(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|unique:user,mobile_number'
        ]);
        $otp = rand(1000000, 9999999);
        $expiresAt = now()->addMinutes(10);
        
        User::create([
            'mobile_number' => $request->mobile_number,
            'otp' => $otp,
            'otp_expires_at' => $expiresAt,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent successfully. Expires at'. $expiresAt,
            'otp' => $otp,
            'current_time' => now(),
            'otp_expires_at' => $expiresAt,
        ]);
    }

    public function verifyRegisterOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required',
            'otp' => 'required',
        ]);
        $user = User::where('mobile_number', $request->mobile_number)
                    ->where('otp', $request->otp)
                    ->where('otp_expires_at', '>', now())
                    ->first();

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP or OTP has expired',
            ]);
        }

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'You have registered successfully',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required',
        ]);

        $user = User::where('mobile_number', $request->mobile_number)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        $user->update(['otp' => $otp, 'otp_expires_at' => $expiresAt]);

        return response()->json(['message' => 'OTP sent', 'otp' => $otp]);
    }

    public function verifyLoginOtp(Request $request)
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
        $id = $request->query('id');
        //dd('in',!auth()->check());
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'user' => $user,
            ]);
        }
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);
    
        // Check if the authenticated user is the same as the user being updated
        if (auth()->user()->id != $id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to update this profile',
            ], 403);
        }
    
        $user->update($request->all());
    
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'message' => 'Profile updated successfully',
        ]);

        if (auth()->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Custom message: You are not authenticated. Please log in to continue.',
                'user' => $user,
            ],401);
        }
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

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email does not match the records'
            ]);
        }else{
            $newPassword = rand(100000, 999999);

            $user->password = Hash::make($newPassword);
            $user->save();

            $to = 'kushc@200oksolutions.com';
            $subject = 'Your new Password';
            $body = 'Your email is : '. $request->email .'. Your new password is: ' . $newPassword;
        
            $result = $this->mailService->sendEmail($to, $subject, $body);
            if($result){
                return response()->json([
                    'status' => 'success',
                    'message' => 'New password has been sent to your email'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send new password'
                ]);
            }
            
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        $currentPassword = $request->current_password;
        $newPassword = $request->new_password;

        $user = auth()->user();

        if (Hash::check($currentPassword, $user->password)) {
            if ($currentPassword === $newPassword) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'New password should not be the same as the current password'
                ]);
            } else {
                $user->update([
                    'password' => Hash::make($newPassword)
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Password changed successfully'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Entered current password does not match the records'
            ]);
        }
    }

}
