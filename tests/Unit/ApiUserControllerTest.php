<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSaveRegister()
    {
        $data = [
            'fname' => 'John',
            'lname' => 'Doe',
            'email' => 'johndoe@example.com',
            'phone' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('save_user'), $data);

        $response->assertStatus(200);

        $response->assertJson([
            'success' => 'Usuário registrado com sucesso',
        ]);

        $this->assertDatabaseHas('users', [
            'fname' => 'John',
            'lname' => 'Doe',
            'email' => 'johndoe@example.com',
        ]);
    }
}
