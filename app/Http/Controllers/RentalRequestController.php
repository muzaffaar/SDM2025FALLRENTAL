<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\RentalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalRequestController extends Controller
{
    public function index() {
        return response()->json(RentalRequest::with(['rental', 'student'])->get());
    }

    public function store(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);
        $studentId = Auth::id();

        $exists = RentalRequest::where('student_id', $studentId)
            ->where('rental_id', $rental->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already sent a request for this rental.');
        }

        RentalRequest::create([
            'student_id' => $studentId,
            'rental_id' => $rental->id,
            'message' => $request->input('message'),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your booking request has been sent successfully!');
    }
}
