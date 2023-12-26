<?php

namespace Tests\Feature\Http\Controllers;

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

        $response = $this->get("quotes");
        $response->assertStatus(200);

        $quotes = $response->original->getData()["page"]["props"]["quotes"];

        $this->assertTrue(count($quotes) === 5);

    }
}
