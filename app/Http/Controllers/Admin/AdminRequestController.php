<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalRequest;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');   // e.g., pending/approved/rejected/reviewed
        $q      = $request->get('q');        // username/email/title search

        $query = RentalRequest::query()
            ->with(['student:id,name,email', 'landlord:id,name,email', 'rental:id,title,location']);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->whereHas('student', fn($s) =>
                $s->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%"))
                    ->orWhereHas('landlord', fn($l) =>
                    $l->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%"))
                    ->orWhereHas('rental', fn($r) =>
                    $r->where('title', 'like', "%{$q}%")
                        ->orWhere('location', 'like', "%{$q}%"));
            });
        }

        $requests = $query->orderByDesc('id')->paginate(20)->withQueryString();

        return view('admin.requests.index', compact('requests', 'status', 'q'));
    }

    // DELETE /admin/requests/{id}
    public function destroy($id)
    {
        $req = RentalRequest::findOrFail($id);
        $req->delete(); // permanent
        return back()->with('status', 'Request removed.');
    }

    // PATCH /admin/requests/{id}/review
    public function markReviewed($id)
    {
        $req = RentalRequest::findOrFail($id);

        // If your enum allows 'reviewed', this will work out of the box.
        // If not, change 'reviewed' to one of your existing statuses.
        $req->update(['status' => 'approved']);

        return back()->with('status', 'Request marked as reviewed.');
    }
}
