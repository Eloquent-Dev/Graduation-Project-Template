<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'national-no' => 'required|unique:users,national_no|size:10',
            'register-email' => 'required|string|email|unique:users,email|max:255',
            'phone_full' => ['required' , 'string', 'regex:/^\+?[0-9]{8,15}$/', 'unique:users,phone'],
            'register-password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:register-password'
        ],
        [],
        [
            'national-no' => 'National Number',
            'register-password' => 'Password',
            'phone_full' => 'Phone Number',
            'register-email' => 'Email Address',
            'password_confirmation' => 'Confirm Password'
        ]);

        $user = User::create([
            'name' => $request->name,
            'national_no' => $request->input('national-no'),
            'email' => $request->input('register-email'),
            'phone' => $request->phone_full,
            'password' => Hash::make($request->input('register-password'))
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success','Account Successfully Created!');
    }

    public function login(Request $request){
        $validated = $request->validate([
            'login-email' => 'required|string|email|max:255',
            'login-password' => 'required|string'
        ],[],
        [
            'login-email' => 'Email Address',
            'login-password' => 'Password'
        ]);

        if(Auth::attempt([
            'email' => $request->input('login-email'),
            'password' => $request->input('login-password')
        ])){
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Account Signed In Successfully!');
        }

            return redirect('/')->with('error','Wrong Email or Password!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
