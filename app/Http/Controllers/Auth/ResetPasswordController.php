<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('admin.login.forgotPassword');
    }
    public function user()
    {
        return view('user.auth.forgotPassword');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->input('email');
    
        $status = Password::sendResetLink(['email' => $email]);
    
        switch ($status) {
            case 'passwords.sent':
                return redirect()->back()->with('success', 'Email berhasil dikirim!');
            case 'passwords.user':
                return redirect()->back()->with('error', 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.');
            case 'passwords.throttled':
                return redirect()->back()->with('error', 'Terlalu banyak percobaan. Silakan coba lagi nanti.');
            default:
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim tautan reset.');
        }
    }
    


    public function resetPasswordIndex($token)
    {
        return view('admin.login.resetPassword', ['token' => $token]);
    }

    public function reset(Request $request)
    {
       
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        $user = User::where('email', '=', $request->only('email'))->first();
        if($status === Password::PASSWORD_RESET){
            if($user->role=='admin'){
                return redirect()->route('admin.login')->with('success', "Reset Password Berhasil");
            }else{
                return redirect()->route('user.loginView')->with('success', "Reset Password Berhasil");
            }
        }else{
           return redirect()->back()->with('error', 'Terjadi kesalahan saat proses reset password.');
        }
    }
}

