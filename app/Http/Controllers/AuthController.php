<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

/**
 * @OA\Info(
 *    title="Test Swagger",
 *    description="An API of cool stuffs",
 *    version="1.0.0",
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Ingrese el token JWT prefijado con Bearer. Ejemplo: 'Bearer {token}'"
 * )
 */

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar un nuevo usuario",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario registrado con éxito"
     *     )
     * )
     */
    public function register(RegisterRequest $request) : JsonResponse
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return $this->respondWithToken((string) $token, $user, 'Usuario registrado con éxito', 201);
    }
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales inválidas"
     *     )
     * )
     */
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

        return $this->respondWithToken($token, Auth::user(), 'Inicio de sesión exitoso', 201);
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesión",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Se cerró sesión correctamente"
     *     )
     * )
     */
    public function logout() : JsonResponse
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Se cerro session'
        ], 200);
    }
    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Renovar token JWT",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token renovado con éxito"
     *     )
     * )
     */
    public function refresh() : JsonResponse
    {
        return $this->respondWithToken(Auth::refresh(), Auth::user(), 'Token renovado', 200);
    }

    protected function respondWithToken(string $token, User $user, string $message, $code): JsonResponse
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
        ], $code);
    }
}
