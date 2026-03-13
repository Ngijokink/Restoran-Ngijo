<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_api_menus_requires_authentication(): void
    {
        $response = $this->getJson('/api/menus');

        $response->assertStatus(401);
    }
}
