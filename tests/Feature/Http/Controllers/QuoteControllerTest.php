<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Quote;

class QuoteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get("quotes");
        $response->assertStatus(200);

        $quotes = $response->original->getData()["page"]["props"]["quotes"];

        $this->assertTrue(count($quotes) === 5);
    }

    public function test_store()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = [
            "user_id" => 1,
            "text" => "asdasdasdasdadasdad"
        ];

        $response = $this->post("quotes",$payload,[
            "accept" => "application/json"
        ]);

        $response->assertRedirect("quotes.index");

        $this->assertDatabaseHas("quotes",[
            "user_id" => $user->id,
            "text" => $payload["text"]
        ]);
    }

    public function test_refresh_quotes()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get("quotes/refresh");
        $response->assertStatus(200);

        $data = $response->json()["data"];

        $this->assertTrue(count($data) === 5);
    }

}
