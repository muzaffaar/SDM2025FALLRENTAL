<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleRedirectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_is_redirected_to_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function landlord_is_redirected_to_landlord_dashboard()
    {
        $user = User::factory()->create(['role' => 'landlord']);
        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function student_is_redirected_to_student_dashboard()
    {
        $user = User::factory()->create(['role' => 'student']);
        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect(route('dashboard'));
    }
}
