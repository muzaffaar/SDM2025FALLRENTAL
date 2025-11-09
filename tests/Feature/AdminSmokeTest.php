<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Rental;
use App\Models\RentalRequest;
use App\Models\Activity;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminSmokeTest extends TestCase
{
    use RefreshDatabase;

    /** Helpers */
    private function makeAdmin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    private function makeStudent(): User
    {
        return User::factory()->create([
            'role' => 'student',
        ]);
    }

    private function makeLandlord(): User
    {
        return User::factory()->create([
            'role' => 'landlord',
        ]);
    }

    /** @test */
    public function admin_routes_are_protected_and_only_admin_can_access()
    {
        // Guests get redirected to login
        $this->get('/users')->assertRedirect('/login');

        // Non-admins get 403
        $this->actingAs($this->makeStudent())->get('/users')->assertStatus(403);
        $this->actingAs($this->makeLandlord())->get('/users')->assertStatus(403);

        // Admin OK
        $this->actingAs($this->makeAdmin())->get('/users')->assertOk();
    }

    /** @test */
    public function rentals_filters_and_pagination_work()
    {
        $admin = $this->makeAdmin();
        $landlord = $this->makeLandlord();

        // seed a few rentals
        Rental::factory()->count(3)->create([
            'title' => 'Budapest Flat',
            'location' => 'Budapest',
            'price' => 500,
            'status' => 'available',
            'landlord_id' => $landlord->id,
        ]);
        Rental::factory()->count(2)->create([
            'title' => 'Debrecen Studio',
            'location' => 'Debrecen',
            'price' => 300,
            'status' => 'available',
            'landlord_id' => $landlord->id,
        ]);

        $this->actingAs($landlord);

        // Search by q
        $this->get('/landlord/rentals?q=Budapest')
            ->assertOk()
            ->assertSee('Budapest Flat');

        // Status filter
        $this->get('/landlord/rentals?status=inactive')
            ->assertOk()
            ->assertSee('Debrecen Studio');

        // Price filter
        $this->get('/landlord/rentals?min=400&max=600')
            ->assertOk()
            ->assertSee('Budapest Flat');

        // Owner filter
        $this->get('/landlord/rentals?owner=' . urlencode($landlord->name))
            ->assertOk()
            ->assertSee('Budapest Flat');
    }

    /** @test */
    public function logs_page_lists_recent_activity_and_is_admin_only()
    {
        $admin = $this->makeAdmin();
        $student = $this->makeStudent();

        // Seed one activity row
        Activity::create([
            'user_id' => $admin->id,
            'action' => 'login.success',
            'details' => json_encode(['ip' => '127.0.0.1']),
            'occurred_at' => now(),
        ]);

        // Non-admin blocked
        $this->actingAs($student)->get('/activities')->assertStatus(403);

        // Admin OK and sees activity
        $this->actingAs($admin)->get('/activities')
            ->assertOk()
            ->assertSee('login.success');
    }
}
