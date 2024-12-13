<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Index: List all users
    public function show()
    {

        $user = Auth::user();
        return response()->json($user, 200);
    }

    // Update: Update user details
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'full_name' => 'required|string|max:128',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|max:32|unique:users,username,' . $id,
        ]);

        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully']);
    }

    // Delete: Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // Patch: Update password
    public function patch(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($validatedData['password']);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }
}

