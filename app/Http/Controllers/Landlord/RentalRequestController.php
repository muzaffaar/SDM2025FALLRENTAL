<?php

namespace App\Http\Controllers\Landlord;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Mail\RequestStatusChanged;
use App\Models\RentalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

            ActivityLogger::log('request.status_updated', [
                'request_id' => $req->id,
                'from' => $old,
                'to' => $req->status,
            ]);

            $student = $req->student;
            $rental  = $req->rental;

            if ($student && $student->email) {
                try {
                    Mail::to($student->email)->send(
                        new RequestStatusChanged(
                            recipientName: $student->name ?? 'Student',
                            rentalTitle:   $rental?->title ?? 'Rental',
                            newStatus:     $req->status,
                            messageForUser:$data['message_for_user'] ?? null
                        )
                    );
                } catch (\Throwable $th) {
                    Log::error('Mail send failed (RequestStatusChanged): '.$th->getMessage(), ['trace' => $th->getTraceAsString()]);
                }
            }

            $landlord = $rental?->landlord;
            if ($landlord && $landlord->email) {
                try {
                    Mail::to($landlord->email)->send(
                        new RequestStatusChanged(
                            recipientName: $landlord->name ?? 'Landlord',
                            rentalTitle:   $rental?->title ?? 'Rental',
                            newStatus:     $req->status,
                            messageForUser: "You set this status for the student's request."
                        )
                    );
                } catch (\Throwable $th) {
                    Log::error('Mail send failed (RequestStatusChanged): '.$th->getMessage(), ['trace' => $th->getTraceAsString()]);
                }
            }

            return back()->with('success', 'Request approved successfully!');
        }

        if ($request->action === 'reject') {
            $req->update(['status' => 'rejected']);

            ActivityLogger::log('request.status_updated', [
                'request_id' => $req->id,
                'from' => $old,
                'to' => $req->status,
            ]);

            $student = $req->student;
            $rental  = $req->rental;

            if ($student && $student->email) {
                try {
                    Mail::to($student->email)->send(
                        new RequestStatusChanged(
                            recipientName: $student->name ?? 'Student',
                            rentalTitle:   $rental?->title ?? 'Rental',
                            newStatus:     $req->status,
                            messageForUser:$data['message_for_user'] ?? null
                        )
                    );
                } catch (\Throwable $th) {
                    Log::error('Mail send failed (RequestStatusChanged): '.$th->getMessage(), ['trace' => $th->getTraceAsString()]);
                }
            }

            $landlord = $rental?->landlord;
            if ($landlord && $landlord->email) {
                try {
                    Mail::to($landlord->email)->send(
                        new RequestStatusChanged(
                            recipientName: $landlord->name ?? 'Landlord',
                            rentalTitle:   $rental?->title ?? 'Rental',
                            newStatus:     $req->status,
                            messageForUser: "You set this status for the student's request."
                        )
                    );
                } catch (\Throwable $th) {
                    Log::error('Mail send failed (RequestStatusChanged): '.$th->getMessage(), ['trace' => $th->getTraceAsString()]);
                }
            }

            return back()->with('success', 'Request rejected successfully!');
        }

        return back()->with('error', 'Invalid action.');
    }

}
