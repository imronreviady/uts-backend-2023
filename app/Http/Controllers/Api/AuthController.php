<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;

use App\Models\User;

use App\Helpers\ResponseFormatter;

class AuthController extends Controller
{
    /**
     * Generate santum token
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $data = $request->only(['email', 'password']);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $message = $validator->getMessageBag()->first();

            return ResponseFormatter::error(null, $message, 500);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseFormatter::error(null, 'Invalid credentials', 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return ResponseFormatter::success([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 'Authenticated');
    }

    /**
     * register new user
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ];

        $data = $request->only(['name', 'email', 'password']);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $message = $validator->getMessageBag()->first();

            return ResponseFormatter::error(null, $message, 500);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return ResponseFormatter::success([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 'Authenticated');
    }

    /**
     * invalidate santum token
     */
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

}
