<?php

namespace Tests\Feature\Http\Controllers\API\v1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_login()
    {
        $user = User::factory()->create();
        $user->email = "jbousing@gmail.com";
        $user->password = Hash::make("testing");
        $user->save();

        $payload = [
            "email" => "jbousing@gmail.com",
            "password" => "testing"
        ];

        $response = $this->post("api/v1/users/login",$payload,[
            "accept" => "application/json"
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
            ]);
    }

    public function test_register()
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $response = $this->post('api/v1/users/register', $payload, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
            ]);
    }

}
