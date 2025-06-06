<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'example123*',
    ]);

    $this->token = JWTAuth::fromUser($this->user);
});

test('Registro de nuevo usuario', function () {
    $data = [
        "name" => "yeremy mendoza",
        "email"=> "nuevo@example.com",  
        "password" => "Example123*",
        "password_confirmation" => "Example123*"
    ];

    $response = $this->postJson('api/register', $data);

    $response->assertStatus(201);
    $response->assertJson(fn(AssertableJson $json) =>
        $json->hasAll([
            'status',
            'message',
            'user.name',
            'user.email',
            'authorization.token',
            'authorization.type',
            'authorization.expires_in'
        ])->where('authorization.type', 'bearer')
    );
});

test('Inicio de sesión', function() {
    $data = [
        "email"=> "test@example.com",
        "password" => "example123*"
    ];

    $response = $this->postJson('api/login', $data);

    $response->assertStatus(201);
    $response->assertJson(fn(AssertableJson $json) =>
        $json->hasAll([
            'status',
            'message',
            'user.name',
            'user.email',
            'authorization.token',
            'authorization.type',
            'authorization.expires_in'
        ])->where('authorization.type', 'bearer')
    );
});

test('Cierre de sesión', function(){
    $response = $this->withHeader('Authorization', "Bearer {$this->token}")
                     ->postJson('/api/logout');

    $response->assertStatus(200);
});
