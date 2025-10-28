<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RedirectShowTest extends TestCase
{
    public function test_redirects_301_and_increments_clicks()
    {
        DB::table('urls')->insert([
            'original_url' => 'https://example.com',
            'short_code' => 'abc123',
            'clicks' =>0,
            'expires_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $res = $this->get('/abc123');

        $res->assertStatus(301)->assertRedirect('https://example.com');

        $this->assertDatabaseHas('urls', [
            'short_code' => 'abc123',
            'clicks' =>1,
        ]);
    }

    public function test_returns_404_when_not_found()
    {
        $this->get('/notfound')->assertStatus(404);
    }

    public function test_returns_410_when_expired()
    {
        DB::table('urls')->insert([
            'original_url' => 'https://example.com',
            'short_code' => 'gone410',
            'clicks' =>0,
            'expires_at' => now()->subMinute(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->get('/gone410')->assertStatus(410);
    }
}
