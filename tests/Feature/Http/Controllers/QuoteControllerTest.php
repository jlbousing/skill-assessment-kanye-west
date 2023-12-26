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
        $userData = $response->original->getData()["page"]["props"]["user"];

        $this->assertTrue(count($quotes) === 5);
        $this->assertTrue($user->id === $userData["id"]);
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

        $response->assertStatus(201);

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

    public function test_destroy()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $quote = Quote::factory()->create();
        $quote->user_id = $user->id;
        $quote->save();

        $response = $this->delete("quotes/quote/{$quote->text}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing("quotes",[
            "user_id" => $user->id,
            "text" => $quote->text
        ]);
    }

    public function test_favorites()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $quotes = Quote::factory(20)->create();
        foreach ($quotes as $quote) {
            $quote->user_id = $user->id;
            $quote->save();
        }

        $response = $this->get("quotes/favorites");
        $response->assertStatus(200);

        $quotesData = $response->original->getData()["page"]["props"]["quotes"];
        $userData = $response->original->getData()["page"]["props"]["user"];

        $this->assertTrue(count($quotesData) === $quotes->count());
        $this->assertTrue($user->id === $userData["id"]);
    }


}
