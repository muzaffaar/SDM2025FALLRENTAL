<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\RentalRequest; // make sure this model exists
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Core counts
        $userCount        = User::count();
        $rentalCount      = Rental::count();

        // Rentals by status (matches your enum)
        $rentalsActive    = Rental::where('status','active')->count();
        $rentalsInactive  = Rental::where('status','inactive')->count();
        $rentalsAvailable = Rental::where('status','available')->count();
        $rentalsRented    = Rental::where('status','rented')->count();

        // Requests (adjust statuses if different in your DB)
        $pendingRequests  = RentalRequest::where('status','pending')->count();
        $approvedRequests = RentalRequest::where('status','approved')->count();
        $rejectedRequests = RentalRequest::where('status','rejected')->count();

        // Optional: quick “today” metrics
        $newUsersToday    = User::whereDate('created_at', Carbon::today())->count();
        $newRentalsToday  = Rental::whereDate('created_at', Carbon::today())->count();

        return view('dashboards.admin', compact(
            'userCount','rentalCount',
            'rentalsActive','rentalsInactive','rentalsAvailable','rentalsRented',
            'pendingRequests','approvedRequests','rejectedRequests',
            'newUsersToday','newRentalsToday'
        ));
    }

    public function activities(Request $request)
    {
        $request->validate([
            'q'          => 'nullable|string|max:255',
            'user'       => 'nullable|string|max:255',
            'action'     => 'nullable|string|max:120',
            'date_from'  => 'nullable|date',
            'date_to'    => 'nullable|date',
        ]);

        $logs = Activity::with('user')
            ->when($request->q, function ($q) use ($request) {
                $term = $request->q;
                $q->where(function ($sub) use ($term) {
                    $sub->where('action', 'like', "%{$term}%")
                        ->orWhere('details', 'like', "%{$term}%");
                });
            })
            ->when($request->user, fn($q) =>
            $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$request->user}%"))
            )
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->when($request->date_from, fn($q) => $q->where('occurred_at', '>=', $request->date_from.' 00:00:00'))
            ->when($request->date_to, fn($q) => $q->where('occurred_at', '<=', $request->date_to.' 23:59:59'))
            ->orderByDesc('occurred_at')
            ->paginate(25)
            ->withQueryString();

        // For action dropdown suggestions
        $actions = Activity::select('action')->distinct()->orderBy('action')->pluck('action');

        return view('admin.activities.index', compact('logs', 'actions'));
    }
}
