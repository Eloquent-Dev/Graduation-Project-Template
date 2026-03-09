<?php

namespace App\Http\Controllers\oAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function handleGoogleCallback(){
        try{
            /** @var \Laravel\Socialite\Two\User $googleUser */
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(['email' => $googleUser->getEmail()],[
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password'=> bcrypt(Str::random(24)),
        ]);

        Auth::login($user);

        return redirect('/')->with('warning','Additional Infromation Needed!');
        }catch(\Exception $e){
            return redirect('/')->with('error','Google login failed. Please try again.');
        }

    }

    public function redirectToGoogle(){
        return Socialite::driver('google')
        ->redirect();
    }

    public function finishRegistration(Request $request){
        $request->validate([
            'national-no' => 'required|unique:users,national_no|size:10',
            'phone_full' => ['required' , 'string', 'regex:/^\+?[0-9]{8,15}$/', 'unique:users,phone'],
        ],[],
        [
            'national-no' => 'National Number',
            'phone_full' => 'phone number',
        ]);

        auth()->user()->update([
            'national_no' => $request->input('national-no'),
            'phone' => $request->phone_full,
        ]);

        return redirect('/')->with('success','Thank You! Your profile is now complete.');
    }
}
