<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function home()
    {
        return view('home-view.home');
    }

    public function shope()
    {
        return view('shope-view.shope');
    }
    public function register()
    {
        return view('register-view.register');
    }
    public function favorite()
    {
        return view('favorite-view.favorite');
    }
    public function myaccount()
    {$user = Auth::user();
        return view('myaccount-view.myaccount',compact('user'));
    }
   
    public function createbids()
    {
        return view('myaccount-view.createbids');
    }
    // public function accountdetails()
    // {
    //     $user = Auth::user(); // Fetch the logged-in user
    //     return view('myaccount-view.accountdetails', compact('user')); // Pass user to the view
    // }
    
    public function edit()
    { $user = Auth::user();
        return view('myaccount-view.accountdetails', compact('user'));
    }

    // Update the specified user in the database
    public function update(Request $request, User $user)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        // Redirect with success message
        return redirect()->route('myaccount-view.accountdetails', $user)->with('success', 'Profile updated successfully!');
    }
    





}
