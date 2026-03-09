<?php

namespace App\Http\Controllers\oAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class MicrosoftController extends Controller
{
    public function handleMicrosoftCallback(){
        try{
            /** @var \Laravel\Socialite\Two\User $microsoftUser */
        $microsoftUser = Socialite::driver('microsoft')->user();

        $user = User::firstOrCreate(['email' => $microsoftUser->getEmail()],[
            'name' => $microsoftUser->getName(),
            'email' => $microsoftUser->getEmail(),
            'password'=> bcrypt(Str::random(24)),
        ]);

        session(['needs_oauth_completion' => true]);

        Auth::login($user);

        return redirect('/')->with('warning','Additional Infromation Needed!');
        }catch(\Exception $e){
            return redirect('/')->with('Microsoft login failed. Please try again.');
        }
    }

    public function redirectToMicrosoft(){
        return Socialite::driver('microsoft')->redirect();
    }
}
