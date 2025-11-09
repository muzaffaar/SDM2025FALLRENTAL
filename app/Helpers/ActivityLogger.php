<?php

namespace App\Helpers;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $action, string|array|null $details = null, ?int $userId = null): void
    {
        try {
            Activity::create([
                'user_id'     => $userId ?? optional(Auth::user())->id,
                'action'      => $action,
                'details'     => is_array($details) ? json_encode($details, JSON_UNESCAPED_UNICODE) : $details,
                'occurred_at' => now(),
            ]);
        } catch (\Throwable $e) {
            \Log::error('Activity logging failed: ' . $e->getMessage());
        }
    }
}
