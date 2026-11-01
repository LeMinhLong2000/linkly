<?php

namespace Tests\Feature;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateLinkTest extends TestCase
{
    // RefreshDatabase giúp chuẩn bị database cho test 
    // và giữ các test độc lập với nhau
    use RefreshDatabase;

    public function test_it_creates_a_short_link(): void
    {
        $response = $this->postJson('/api/links', [
            'url' => 'https://example.com/backend',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'code',
                    'short_url',
                    'original_url',
                ],
            ]);

        $this->assertDatabaseHas('links', [
            'original_url' => 'https://example.com/backend',
        ]);
    }

    public function test_it_rejects_an_invalid_url(): void
    {
        $response = $this->postJson('/api/links', [
            'url' => 'not-a-url',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['url']);

        $this->assertDatabaseCount('links', 0);
    }

    public function test_it_rejects_a_missing_url(): void
    {
        $response = $this->postJson('/api/links', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['url']);
    }
}
