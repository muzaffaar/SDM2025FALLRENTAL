<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index() {
        return response()->json(Activity::with('user')->get());
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|string',
            'details' => 'nullable|string'
        ]);

        $validated['created_at'] = now();
        $activity = Activity::create($validated);
        return response()->json($activity, 201);
    }
}
