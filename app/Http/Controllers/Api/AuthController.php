<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'role' => 'nullable|in:Guest,Admin'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Error Validation',
                'data' => [
                    $validator->errors()
                ],
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token = $user->createToken('authtoken')->plainTextToken;

        return response()->json([
            'status_code' => 200,
            'message' => 'User Created Successfully',
            'data' => [
                'name' => $user->name,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            if (!auth()->attempt($credentials)) {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Unauthorized',
                ]);
            }

            $user = auth()->user();
            $token = $user?->createToken('authtoken')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'message' => 'Authorized',
                'data' => [
                    'name' => $user?->name,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ],
            ]);
        } catch (Exception) {
            return response()->json([
                'status_code' => 500,
                'message' => 'An Error Occurred. Try Again.'
            ]);
        }
    }
}
