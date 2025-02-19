<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,vendor,patient'],
            'shop_name' => ['nullable', 'string', 'max:255', 'required_if:role,vendor'],
            'shop_url' => ['nullable', 'url', 'max:255', 'required_if:role,vendor'],
            'phone_number' => ['nullable', 'string', 'max:20', 'required_if:role,vendor'],
        ]);

        // Hash the password before saving
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create the user
        $user = User::create($validatedData);

        // Automatically log in the user after registration
        auth()->login($user);

        return redirect()->route('home-view.home')->with('success', 'Registration successful!');
    }
}
