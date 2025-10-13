<?php

namespace App\Http\Controllers;

use App\Models\RentalRequest;
use Illuminate\Http\Request;

class RentalRequestController extends Controller
{
    public function index() {
        return response()->json(RentalRequest::with(['rental', 'student'])->get());
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'student_id' => 'required|exists:users,id',
            'status' => 'in:pending,approved,rejected',
            'message' => 'nullable|string'
        ]);

        $requestModel = RentalRequest::create($validated);
        return response()->json($requestModel, 201);
    }
}
