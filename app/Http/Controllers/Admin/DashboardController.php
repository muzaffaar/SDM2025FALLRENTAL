<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
