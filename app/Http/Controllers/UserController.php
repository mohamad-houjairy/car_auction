<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
;


class UserController extends Controller
{
     // Display a list of users
     public function index()
     {
         $users = User::all();
         return view('users.index', compact('users'));
     }
 
     // Show the form for editing a specific user
     public function edit(User $user)
     {
         return view('users.edit', compact('user'));
     }
 
     // Update the specified user in the database
     public function update(Request $request, User $user)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
             'password' => 'nullable|string|min:8|confirmed',
             'role' => 'required|in:admin,vendor,patient',
         ]);
 
         $user->name = $request->name;
         $user->email = $request->email;
         if ($request->filled('password')) {
             $user->password = Hash::make($request->password);
         }
         $user->role = $request->role;
         $user->save();
 
         return redirect()->route('users.index')->with('success', 'User updated successfully!');
     }
     
     // Delete the specified user
     public function destroy(User $user)
     {
         $user->delete();
         return redirect()->route('users.index')->with('success', 'User deleted successfully!');
     }
}
