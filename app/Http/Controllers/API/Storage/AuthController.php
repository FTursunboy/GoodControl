<?php

namespace App\Http\Controllers\API\Storage;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;
use function response;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function login(LoginRequest $request) : JsonResponse
    {
        $data = $request->validated();
        $user = $this->authService->login($data);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Неверный логин или пароль'
            ]);
        }

        return response()->json([
            'status' => true,
            'token' => $user->createToken('token')->plainTextToken,
            'role' => $user->getRoleNames()->first()
        ]);
    }
}
