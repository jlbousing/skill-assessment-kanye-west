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

        $response = $this->get("api/v1/quotes?user={$user->id}",[
            "Content-type" => "application/json",
            "Accept" => "application/json"
        ]);
        $response->assertStatus(401);
    }

    public function test_get_quotes_by_specif_quantity_and_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $quotes = Quote::factory(50)->create();

        foreach ($quotes as $quote) {
            $quote->user_id = $user->id;
            $quote->save();
        }

        $qtx = 8;

        $response = $this->get("api/v1/quotes?user={$user->id}&qtx={$qtx}");
        $response->assertStatus(200);

        $data = $response->json()["data"];

        $this->assertTrue(count($data) === $qtx);
    }

    public function test_get_quotes_by_specif_quantity_and_without_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $quotes = Quote::factory(50)->create();

        foreach ($quotes as $quote) {
            $quote->user_id = $user->id;
            $quote->save();
        }

        $qtx = 10;

        $response = $this->get("api/v1/quotes?qtx={$qtx}");
        $response->assertStatus(200);

        $data = $response->json()["data"];

        $this->assertTrue(count($data) === $qtx);
    }

    public function test_get_quotes_by_five_random()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $quotes = Quote::factory(50)->create();

        foreach ($quotes as $quote) {
            $quote->user_id = $user->id;
            $quote->save();
        }

        $qtx = 5;

        $response = $this->get("api/v1/quotes");
        $response->assertStatus(200);

        $data = $response->json()["data"];

        $this->assertTrue(count($data) === $qtx);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $quotes = Quote::factory(50)->create();

        $response = $this->get("api/v1/quotes/{$quotes[0]->id}");
        $response->assertStatus(200);

        $data = $response->json()["data"];

        $this->assertTrue($data["id"] === $quotes[0]->id);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $quote = Quote::factory()->create();
        $quote->user_id = $user->id;
        $quote->save();

        $response = $this->delete("api/v1/quotes/{$quote->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing("quotes",[
            "user_id" => $user->id,
            "text" => $quote->text
        ]);
    }



}
