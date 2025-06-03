<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    //
    public function register(RegisterRequest $request) : JsonResponse
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return $this->respondWithToken($token, $user, 'Usuario registrado con éxito');
    }

    public function login(LoginRequest $request) : JsonResponse
    {

        $request->validated();

        $credentials = $request->only(['email', 'password']);

        $token = Auth::attempt($credentials);
        if(!$token){
            return response()->json([
                'status' => 'error',
                'message' => 'credenciales invalidas',
            ], 401);
        }

        $user = Auth::user();

        return $this->respondWithToken($token, Auth::user(), 'Inicio de sesión exitoso');
    }

    public function logout() : JsonResponse
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Se cerro session'
        ]);
    }

    public function refresh() : JsonResponse
    {
        return $this->respondWithToken(Auth::refresh(), Auth::user(), 'Token renovado');
    }

    protected function respondWithToken(string $token, User $user, string $message): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'user' => $user->only(['name', 'email']),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
            ],
        ]);
    }
}
