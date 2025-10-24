<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
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

    public function index(Request $request)
    {
        $rentals = Rental::query()
            ->where('landlord_id', Auth::id()) // only landlord’s rentals
            ->when($request->keyword, fn($q) =>
            $q->where('title', 'like', "%{$request->keyword}%")
                ->orWhere('description', 'like', "%{$request->keyword}%")
            )
            ->when($request->location, fn($q) =>
            $q->where('location', 'like', "%{$request->location}%")
            )
            ->when($request->min_price, fn($q) =>
            $q->where('price', '>=', $request->min_price)
            )
            ->when($request->max_price, fn($q) =>
            $q->where('price', '<=', $request->max_price)
            )
            ->latest()
            ->get();
        return view('landlord.rentals.index', compact('rentals'));
    }

    public function edit($id)
    {
        $rental = Rental::where('landlord_id', Auth::id())->findOrFail($id);
        return view('landlord.rentals.edit', compact('rental'));
    }

    public function update(Request $request, $id)
    {
        $rental = Rental::where('landlord_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Replace image if uploaded
        if ($request->hasFile('image')) {
            if ($rental->image_path && Storage::disk('public')->exists($rental->image_path)) {
                Storage::disk('public')->delete($rental->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('rentals', 'public');
        }

        $rental->update($validated);

        return redirect()->route('landlord.rentals.index')
            ->with('success', 'Rental updated successfully!');
    }

    public function destroy($id)
    {
        $rental = Rental::where('landlord_id', Auth::id())->findOrFail($id);

        try {
            if ($rental->image_path && Storage::disk('public')->exists($rental->image_path)) {
                Storage::disk('public')->delete($rental->image_path);
            }

            $rental->delete();
            return redirect()->route('landlord.rentals.index')
                ->with('success', 'Rental deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('landlord.rentals.index')
                ->with('error', 'Failed to delete rental.');
        }
    }
}
