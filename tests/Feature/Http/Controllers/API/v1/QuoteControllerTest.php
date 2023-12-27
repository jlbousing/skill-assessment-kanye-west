<?php

namespace Tests\Feature\Http\Controllers\API\v1;

use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;


class QuoteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $quotes = Quote::factory(50)->create();

        foreach ($quotes as $quote) {
            $quote->user_id = $user->id;
            $quote->save();
        }

        $response = $this->get("api/v1/quotes?user={$user->id}");
        $response->assertStatus(200);

        $data = $response->json()["data"];

        $this->assertTrue($data["meta"]["total"] === $quotes->count());
    }

    public function test_index_without_token()
    {
        $user = User::factory()->create();

        $quotes = Quote::factory(50)->create();

        foreach ($quotes as $quote) {
            $quote->user_id = $user->id;
            $quote->save();
        }

        $response = $this->get("api/v1/quotes?user={$user->id}");
        $response->assertStatus(401);
    }

}
