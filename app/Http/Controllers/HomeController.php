<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        $rentals = \App\Models\Rental::where('status', 'active')
            ->with('images')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('rentals'));
    }
}
