<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_returns_paginated_list()
    {
        for ($i =0; $i <6; $i++) {
            Url::create([
                'original_url' => 'https://www.example.com/some/very/long/path/' . $i,
                'short_code' => 'code' . $i,
                'clicks' =>0,
                'expires_at' => null,
            ]);
        }

        $res = $this->getJson('/api/v1/urls');

        $res->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['original_url', 'short_code', 'clicks', 'created_at'],
                ],
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ]);

        $this->assertCount(5, $res->json('data'));
    }
}
