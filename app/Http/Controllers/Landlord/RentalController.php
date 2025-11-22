<?php

namespace App\Http\Controllers\Landlord;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\RentalImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    public function create()
    {
        return view('landlord.rentals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $title = strip_tags($validated['title']);
        $description = strip_tags($validated['description']);

        $rental = Rental::create([
            'title' => $title,
            'description' => $description,
            'price' => $validated['price'],
            'location' => $validated['location'],
            'landlord_id' => Auth::id(),
            'status' => 'available',
        ]);

        ActivityLogger::log('rental.created', [
            'rental_id' => $rental->id,
            'title' => $rental->title,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rentals', 'public');
                $rental->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('landlord.dashboard')
            ->with('success', 'Rental listing created successfully with images!');
    }

    public function index(Request $request)
    {
        $rentals = Rental::query()
            ->where('landlord_id', Auth::id())
            ->with('images')
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
        $rental = Rental::where('landlord_id', Auth::id())->with('images')->findOrFail($id);
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $rental->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rentals', 'public');
                $rental->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('landlord.rentals.index')
            ->with('success', 'Rental updated successfully!');
    }

    public function destroy($id)
    {
        $rental = Rental::where('landlord_id', Auth::id())->with('images')->findOrFail($id);

        try {
            foreach ($rental->images as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }

            $rental->delete();

            return redirect()->route('landlord.rentals.index')
                ->with('success', 'Rental and all images deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('landlord.rentals.index')
                ->with('error', 'Failed to delete rental.');
        }
    }
}
