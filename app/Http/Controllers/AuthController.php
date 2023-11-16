<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        $auth = Auth::attempt($request->only('email', 'password'));

        if (!$auth) {
            return response()->json([
                'message' => 'Invalid user'
            ], 400);
        }

        // $request->session()->regenerate();

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'message' => 'Ok',
            'data' => $user,
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ], 200);
    }

    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Ok'
        ], 200);
    }
}
