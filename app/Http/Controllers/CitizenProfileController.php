<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CitizenProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.citizen.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.citizen.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'edit_name' => 'required|string|max:255',

            'edit_national_no' =>['nullable', Rule::unique('users','national_no')->ignore($user->id), 'size:10'],

            'edit_email' => ['required', 'string', 'email', Rule::unique('users','email')->ignore($user->id), 'max:255'],

            'edit_phone' => ['nullable', 'string', 'regex:/^\+?[0-9]{8,15}$/', Rule::unique('users','phone')->ignore($user->id)],
        ]);

        $user->update([
            'name' => $validated['edit_name'],
            'national_no' => $validated['edit_national_no'],
            'email' => $validated['edit_email'],
            'phone' => $validated['edit_phone'],
        ]);

        return redirect()->route('citizen.profile.show')->with('success', 'Your profile updated successfully.');
    }



    public function updatePassword(Request $request)
    {

        $user = $request->user();
        $rule = [
            'new_password' => ['required','confirmed',Password::defaults()],
        ];

        if($user->password){
            $rule['current_password'] = ['required', 'current_password'];
        }

        $validated = $request->validate($rule);

        $user->update([
            'password' => $validated['new_password'],
        ]);

        return redirect()->route('citizen.profile.show')
        ->with('success', 'Your password updated successfully.');
    }

}
