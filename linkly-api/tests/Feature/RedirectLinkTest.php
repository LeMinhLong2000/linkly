<?php

namespace Tests\Feature;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_redirects_to_the_original_url(): void
    {
        $link = Link::create([
            'original_url' => 'https://example.com/backend',
            'code' => 'abc12345',
            'is_active' => true,
        ]);

        $response = $this->get('/' . $link->code);

        $response->assertRedirect(
            'https://example.com/backend'
        );

        $response->assertStatus(302);
    }

    public function test_it_returns_404_for_an_unknown_code(): void
    {
        $this->get('/notfound')
            ->assertNotFound();
    }

    public function test_it_does_not_redirect_an_inactive_link(): void
    {
        $link = Link::create([
            'original_url' => 'https://example.com/backend',
            'code' => 'abc12345',
            'is_active' => false,
        ]);

        $this->get('/' . $link->code)
            ->assertNotFound();
    }
}