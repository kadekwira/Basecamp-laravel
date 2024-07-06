<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthAdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        $user = User::where('email', $credentials['email'])
                    ->where('role', 'admin')
                    ->where('status', 'active')
                    ->first();
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard.index')->with('success', 'Berhasil Login');
        }
    
        return redirect()->back()->withErrors(['error' => 'Email dan Password Salah!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Berhasil Logout');
    }
}
