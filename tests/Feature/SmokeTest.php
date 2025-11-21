<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    /** @test */
    public function app_homepage_loads()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function app_can_boot_without_crashing()
    {
        $this->assertTrue(app()->isBooted());
    }

    /** @test */
    public function database_connection_is_working()
    {
        $this->assertDatabaseCount('users', 0);
    }

    /** @test */
    public function important_routes_are_up()
    {
        $routes = ['/', '/login', '/register'];

        foreach ($routes as $route) {
            $this->get($route)->assertStatus(200);
        }
    }
}
