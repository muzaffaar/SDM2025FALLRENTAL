<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::where('status', 'available');

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $rentals = $query->paginate(9);

        return view('student.rentals.index', compact('rentals'));
    }

    public function create()
    {
        return view('landlord.rentals.create');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            // store image in storage/app/public/rentals
            $path = $request->file('image')->store('rentals', 'public');
        }

        Rental::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'location' => $validated['location'],
            'landlord_id' => Auth::id(),
            'status' => 'available',
            'image_path' => $path,
        ]);

        return redirect()->route('landlord.dashboard')
            ->with('success', 'Rental listing created successfully!');
    }
}
