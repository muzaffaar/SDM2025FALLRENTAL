<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Rental;
use App\Models\RentalRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RentalFeatureTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** @test */
    public function student_can_browse_and_filter_rentals()
    {
        $this->seed(); // optional, if you have seeders
        $landlord = User::factory()->create(['role' => 'landlord']);
        $rental = Rental::factory()->create([
            'title' => 'Cozy Apartment',
            'location' => 'Debrecen',
            'price' => 500,
            'landlord_id' => $landlord->id,
        ]);

        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($student)
            ->get('/rentals?location=Debrecen&min_price=100&max_price=800');

        $response->assertStatus(200);
        $response->assertSee('Cozy Apartment');
    }

    /** @test */
    public function student_cannot_send_duplicate_rental_requests()
    {
        // Arrange
        $landlord = User::factory()->create(['role' => 'landlord']);
        $rental = Rental::factory()->create(['landlord_id' => $landlord->id]);
        $student = User::factory()->create(['role' => 'student']);

        // First request
        $this->actingAs($student)->post(route('student.rentals.request', $rental->id), [
            'message' => 'Interested in renting!',
        ]);

        sleep(1);
        // Assert first request created
        $this->assertDatabaseHas('rental_requests', [
            'rental_id' => $rental->id,
            'student_id' => $student->id,
            'status' => 'pending',
            'message' => 'Interested in renting!',
        ]);

        // Second request attempt
        $response = $this->actingAs($student)->post("/rentals/{$rental->id}/request", [
            'message' => 'Trying again!',
        ]);

        // Assert: duplicate is blocked
        $response->assertRedirect();
        $response->assertSessionHas('error', 'You have already sent a request for this rental.');

        // Ensure still only one record exists
        $this->assertEquals(1, \App\Models\RentalRequest::count());
    }

    /** @test */
    public function landlord_can_create_and_delete_rental()
    {
        Storage::fake('public');
        $landlord = User::factory()->create(['role' => 'landlord']);

        // landlord creates a rental
        $response = $this->actingAs($landlord)->post('/landlord/rentals', [
            'title' => 'Modern Flat',
            'description' => 'Nice flat downtown',
            'price' => 700,
            'location' => 'Budapest',
            'images' => [UploadedFile::fake()->image('photo1.jpg')],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('rentals', ['title' => 'Modern Flat']);

        $rental = Rental::first();

        // landlord deletes it
        $deleteResponse = $this->actingAs($landlord)
            ->delete("/landlord/rentals/{$rental->id}");

        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('rentals', ['id' => $rental->id]);
    }

    /** @test */
    public function landlord_can_approve_or_reject_rental_request()
    {
        $landlord = User::factory()->create(['role' => 'landlord']);
        $student = User::factory()->create(['role' => 'student']);
        $rental = Rental::factory()->create(['landlord_id' => $landlord->id]);
        $request = RentalRequest::factory()->create([
            'rental_id' => $rental->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($landlord)
            ->put("/landlord/requests/{$request->id}", ['action' => 'approve']);
        sleep(2);
        $this->assertDatabaseHas('rental_requests', [
            'id' => $request->id,
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function unauthorized_users_cannot_access_landlord_routes()
    {
        $student = User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->get('/landlord/rentals');
        $response->assertStatus(200);
    }
}
