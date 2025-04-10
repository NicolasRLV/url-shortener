<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{
    public function test_encode_endpoint_returns_short_url()
    {
        $response = $this->postJson('/api/encode', [
            'url' => 'https://www.example.com/very/long/url/with/parameters'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['short_url']);
    }

    public function test_decode_endpoint_returns_original_url()
    {
        $encodeResponse = $this->postJson('/api/encode', [
            'url' => 'https://www.example.com/very/long/url/with/parameters'
        ]);

        $shortUrl = $encodeResponse->json('short_url');

        $decodeResponse = $this->postJson('/api/decode', [
            'short_url' => $shortUrl
        ]);

        $decodeResponse
            ->assertStatus(200)
            ->assertJson([
                'original_url' => 'https://www.example.com/very/long/url/with/parameters'
            ]);
    }

    public function test_encode_validation_fails_with_invalid_url()
    {
        $response = $this->postJson('/api/encode', [
            'url' => 'not-a-valid-url'
        ]);

        $response->assertStatus(422);
    }

    public function test_decode_returns_404_for_invalid_short_url()
    {
        $response = $this->postJson('/api/decode', [
            'short_url' => 'http://localhost:8000/invalid'
        ]);

        $response->assertStatus(404);
    }
}
