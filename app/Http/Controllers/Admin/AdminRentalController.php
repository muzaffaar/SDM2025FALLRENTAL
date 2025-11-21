<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRentalController extends Controller
{
    public function index(Request $request)
    {
        $q = Rental::query();

        if ($search = $request->get('search')) {
            $q->where(function ($qq) use ($search) {
                $qq->where('title', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $rentals = $q->orderByDesc('id')->paginate(20)->withQueryString();

        return view('admin.rentals.index', compact('rentals'));
    }

    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->delete(); // permanent delete
        return back()->with('status', 'Rental deleted.');
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['active','inactive'])],
        ]);

        $rental = Rental::findOrFail($id);
        $rental->status = $validated['status'];
        $rental->save();

        return back()->with('status', 'Status updated.');
    }
}
