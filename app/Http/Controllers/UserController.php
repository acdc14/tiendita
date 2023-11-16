<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::simplePaginate(3);
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'birthdate' => 'required|date',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed',
        ])->validate();

        User::create([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Created'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!empty($user)) {
            return response()->json([
                'message' => 'Ok',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'message' => 'Not Found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'birthdate' => 'required|date',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ])->validate();

        $exist = User::where('id', $id)->exists();

        if ($exist) {
            $user = User::find($id);

            $user->update($request->all());

            return response()->json([
                'message' => 'Updated'
            ], 204);
        }

        return response()->json([
            'message' => 'Not Found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exist = User::where('id', $id)->exists();

        if ($exist) {
            $user = User::find($id);
            $user->delete();

            return response()->json([
                'message' => 'Deleted'
            ], 204);
        }

        return response()->json([
            'message' => 'Not Found'
        ], 404);
    }
}
