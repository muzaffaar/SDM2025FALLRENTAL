<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $summary = [
            'users_total'   => User::count(),
            'admins_total'  => User::where('role', 'admin')->count(),
            'db_connection' => config('database.default'),
            'php_version'   => PHP_VERSION,
            'laravel_ver'   => app()->version(),
        ];

        return view('dashboards.admin', compact('summary'));
    }
}
