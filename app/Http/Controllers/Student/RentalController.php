<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = Rental::select('id','title','location','price','status','landlord_id')
            ->with(['images' => function ($q) {
                $q->select('id', 'rental_id', 'image_path');
            }])
            ->where('status', 'active');

        $hasFilters = $request->filled('location') ||
            $request->filled('min_price') ||
            $request->filled('max_price');

        if (! $hasFilters) {
            $page = $request->get('page', 1);
            $cacheKey = "active_rentals_page_{$page}";

            $rentals = Cache::remember($cacheKey, 600, function () use ($baseQuery) {
                return $baseQuery->paginate(9);
            });

            return view('student.rentals.index', compact('rentals'));
        }

        if ($request->filled('location')) {
            $baseQuery->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('min_price')) {
            $baseQuery->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $baseQuery->where('price', '<=', $request->max_price);
        }

        $rentals = $baseQuery->paginate(9);

        return view('student.rentals.index', compact('rentals'));
    }

    public function show($id)
    {
        $rental = Rental::findOrFail($id);
        return view('student.rentals.show', compact('rental'));
    }
}
