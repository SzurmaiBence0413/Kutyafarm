<?php

namespace Tests\Feature;

use Tests\TestCase;

class PingTest extends TestCase
{
    public function test_api_ping_endpoint_returns_api_text(): void
    {
        $response = $this->get('/api/x');

        $response->assertStatus(200);
        $response->assertSee('API');
    }
}

