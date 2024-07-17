<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthCustomerController extends Controller
{
    public function viewLogin(){
        return view('user.auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        $user = User::where('email', $credentials['email'])
                    ->where('role', 'customer')
                    ->where('status', 'active')
                    ->first();
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('user.index')->with('success', 'Berhasil Login');
        }
    
        return redirect()->back()->withErrors(['error' => 'Email dan Password Salah!']);
    }



    public function viewDaftar(){
        return view('user.auth.regis');
    }

    public function daftar(Request $request){

                if($request->password!==$request->password2){
                    return redirect()->back()->with('error',"Pastikan Password dan Konfirmasi Sama");
                }

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'address' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'phone' => 'required|numeric|digits_between:10,15',
                    'password' => 'required|string|min:8',
                    'ktp' => 'required|file|mimes:jpg,png,pdf|max:2048',
                ]);
                
        
                if ($validator->fails()) {
                    return redirect()->back()->with('error',$validator->errors()->first());
                }
        
                if ($request->hasFile('ktp')) {
                    $ktpPath = $request->file('ktp')->store('ktp', 'public');
                }
        
                // Create the user
                $user = User::create([
                    'name' => $request->name,
                    'address' => $request->address,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'ktp' => $ktpPath,
                    'role'=>"customer",
                    'status'=>"active"
                ]);
        
                return redirect()->route('user.loginView')->with('success', 'Account created successfully!');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('user.index')->with('success', 'Berhasil Logout');
    }
}
