<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
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
            $token = $user->createToken('authtoken')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (Exception) {
            return response()->json([
                'status_code' => 500,
                'message' => 'An Error Occurred. Try Again.'
            ]);
        }
    }
}
