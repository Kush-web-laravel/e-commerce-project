<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\SubAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\MailService;
class LoginController extends Controller
{
    //
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }
    public function login()
    {
        return view('auth.login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::guard('admin')->attempt($request->only('email', 'password'))){
            return redirect()->route('dashboard-view');
        }else{
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
    }

    public function forgotPasswordView()
    {
        return view('auth.password.forgot');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = Admin::where('email', $request->email)->first();

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
                    'message' => 'New password has been sent to your email',
                    'redirect_url' => route('login-view')
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send new password'
                ]);
            }
            
        }
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        request()->session()->invalidate(); 
        request()->session()->regenerateToken(); 

        return redirect()->route('login-view');
    }

    public function changePasswordView()
    {
        return view('auth.password.change');
    }


    public function verifyCurrentPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        $currentPassword = $request->current_password;
        $user = Auth::guard('admin')->user();

        if (Hash::check($currentPassword, $user->password)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Current password is correct'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Entered current password does not match the records'
            ]);
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

        $user = Auth::guard('admin')->user();

        if (Hash::check($currentPassword, $user->password)) {
            if ($currentPassword === $newPassword) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'New password should not be the same as the current password'
                ]);
            } else {
                $user->update([
                    'password' => bcrypt($newPassword)
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Password changed successfully',
                    'redirect_url' => route('dashboard-view')
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Entered current password does not match the records'
            ]);
        }
    }

    public function profileView()
    {
        return view('auth.profile.update');
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|email|unique:admins,email,' . $user->id,
            'address' => 'required|max:200',
            'city' => 'required|max:20',
            'state' => 'required|max:25'
        ]);
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'redirect_url' => route('dashboard-view')
        ]);
    }


    public function subAdminList()
    {
        $subadmins = SubAdmin::all();
        return view('admin.sub-admin', compact('subadmins'));
    }


    public function addSubAdmin()
    {
        return view('admin.subadmin.add');
    }

    public function subAdminStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|email|unique:sub_admins',
            'password' => 'required|confirmed|max:10',
        ]);

        SubAdmin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sub Admin Added Successfully',
            'redirect_url' => route('subAdmin-view')
        ]);
    }

    public function editSubAdmin($id)
    {
        $subadmin = SubAdmin::find($id);
        return view('admin.subadmin.edit', compact('subadmin'));
    }

    public function updateSubAdmin(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|email|unique:sub_admins,email,' . $id
        ]);

        $subadmin = SubAdmin::findOrFail($id);

        $subadmin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sub Admin Updated Successfully',
            'redirect_url' => route('subAdmin-view')
        ]);
    }

    public function deleteSubAdmin($id)
    {
        $subadmin = SubAdmin::findOrFail($id);

        if($subadmin){
            $subadmin->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Sub Admin Deleted Successfully',
                'redirect_url' => route('subAdmin-view')
            ]);
        }
    }
}
