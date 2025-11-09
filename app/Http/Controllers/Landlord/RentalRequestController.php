<?php

namespace App\Http\Controllers\Landlord;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\RentalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalRequestController extends Controller
{
    public function landlordRequests()
    {
        $requests = RentalRequest::with(['rental', 'student'])
            ->whereHas('rental', function ($query) {
                $query->where('landlord_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('landlord.requests.index', compact('requests'));
    }

    public function updateStatus(Request $request, $id)
    {
        $req = RentalRequest::findOrFail($id);
        $old = $req->status;
        // Ensure the landlord owns this rental
        if ($req->rental->landlord_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($request->action === 'approve') {
            $req->update(['status' => 'approved']);
            return back()->with('success', 'Request approved successfully!');
        }

        if ($request->action === 'reject') {
            $req->update(['status' => 'rejected']);
            return back()->with('success', 'Request rejected successfully!');
        }

        ActivityLogger::log('request.status_updated', [
            'request_id' => $req->id,
            'from' => $old,
            'to' => $req->status,
        ]);

        return back()->with('error', 'Invalid action.');
    }

}
