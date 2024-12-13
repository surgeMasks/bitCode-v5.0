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
    public function update(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:128',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'username' => 'required|string|max:32|unique:users,username,' . $request->user()->id,
            'uni_reg_no' => 'required|string|max:10|unique:users,uni_reg_no,' . $request->user()->id,
            'university_id' => 'required|exists:universities,id',
    ]);

        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully']);
    }

    // Delete: Delete a user
    public function destroy(Request $request)
    {
        $user = Auth::user();
         if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['message' => 'Password is incorrect'], 401);
        }
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // Patch: Update password
    public function patch(Request $request)
    {
        $validatedRequest = $request->validate([
            'oldPassword' => 'required|string',
            'newPassword' => 'required|min:6|max:16|confirmed',
        ]);
        $user = Auth::user();

        $newPassword = $validatedRequest['newPassword'];

        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json(['message' => 'Password updated'], 200);
    }
}

