<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlStoreTest extends TestCase{
    use RefreshDatabase;

    public function test_store_creates_short_url()
    {
        $res = $this->postJson('/api/v1/shorten', [
            'url' => 'https://example.com/long/path',
            'ttl_days' =>2,
        ]);

        $res->assertCreated()
            ->assertJsonStructure(['short_url']);
    }
}
