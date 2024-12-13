<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Student;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $validatedRequest = $request->validated();
        if (!Auth::attempt([
            'email' => $validatedRequest['email'],
            'password' => $validatedRequest['password']
        ]) && !Auth::attempt([
            'username' => $validatedRequest['username'],
            'password' => $validatedRequest['password']
        ])) {
            return response()->json(['msg' => 'Invalid Credentials'], 401);
        }

        // if the user has another token delete it from the database
        $request->user()->tokens()->delete();

        $user = Auth::user();
        $token = $user->createToken("API token of " . $user->first_name)->plainTextToken;

        return response()->json([
            'message' => 'Login Successful',
            'token' => $token,
        ], 200);

    }

    public function register(RegisterUserRequest $request)
    {
        $validatedRequest = $request->validated();

        //create user and student
        $user = DB::transaction(function () use ($validatedRequest) {
            $user = $this->createUser($validatedRequest);

            Auth::login($user);

            return $user;
        });

        $token = $user->createToken('API token of '. $user->first_name)->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login Successful',
        ], 200);
    }

    public function logOut(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['msg' => 'Logged Out'], 200);
    }

    // utility functions
    /**
     * Create a new user record
     */
    private function createUser($validatedRequest)
    {
       return User::create([
            'full_name' => $validatedRequest['full_name'],
            'username' => $validatedRequest['username'],
            'email' => $validatedRequest['email'],
            'password' => Hash::make($validatedRequest['password']),
            'uni_reg_no' => $validatedRequest['uni_reg_no'],
            'university_id' => $validatedRequest['university_id'],
        ]);
    }

}
