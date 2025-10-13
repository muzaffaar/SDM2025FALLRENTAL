<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index() {
        return response()->json(Rental::with('landlord')->get());
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string',
            'landlord_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string',
            'status' => 'in:available,rented,pending',
            'image_path' => 'nullable|string',
        ]);

        $rental = Rental::create($validated);
        return response()->json($rental, 201);
    }
}
