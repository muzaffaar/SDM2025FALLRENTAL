<?php

namespace Tests\Unit;

use App\Helpers\ActivityLogger;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class ActivityLoggerTest extends TestCase
{
    use RefreshDatabase;

    public function test_logs_activity_with_authenticated_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        ActivityLogger::log('test_action', 'some detail', $user->id);

        $this->assertDatabaseHas('loggers', [
            'user_id' => $user->id,
            'action'  => 'test_action',
            'details' => 'some detail',
        ]);
    }

    public function test_logs_activity_with_explicit_userid_overrides_auth()
    {
        $authUser = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($authUser);

        ActivityLogger::log('action_override', null, $otherUser->id);

        $this->assertDatabaseHas('loggers', [
            'user_id' => $otherUser->id,
            'action'  => 'action_override',
        ]);
    }

    public function test_array_details_are_json_encoded()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $details = ['a' => 'б', 'b' => 2]; // unicode check
        ActivityLogger::log('action_with_array', $details);

        $this->assertDatabaseHas('loggers', [
            'user_id' => $user->id,
            'action'  => 'action_with_array',
            'details' => json_encode($details, JSON_UNESCAPED_UNICODE),
        ]);
    }

    public function test_when_activity_create_throws_it_is_caught_and_logged()
    {
        // Make sure we don't reference Activity::class anywhere before we drop the table.
        $this->expectNotToPerformAssertions();
        // Expect Log::error to be called once with our message containing 'Activity logging failed' and the DB error message
        Log::shouldReceive('error')
            ->once()
            ->withArgs(function ($message) {
                return str_contains($message, 'Activity logging failed:') && str_contains($message, 'SQL') || str_contains($message, 'no such table') || str_contains($message, 'SQLSTATE');
            });

        // Drop the activities table to force a DB exception when the helper tries to create.
        // This simulates Activity::create() throwing without touching Mockery aliasing.
        \Schema::dropIfExists('loggers');

        // Call the logger — it should catch the thrown exception and call Log::error().
        // No exception must bubble up to the test runner.
        ActivityLogger::log('will_throw', 'x');

        // (Optionally) recreate table so other tests remain stable — RefreshDatabase will run per test anyway,
        // but if your setup persists across tests you can re-run migrations:
        // $this->artisan('migrate');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
