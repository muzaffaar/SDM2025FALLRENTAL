{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Admin Dashboard</h1>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="card"><div class="card-body">
                        <h6 class="text-muted">Total Users</h6>
                        <div class="fs-3">{{ $summary['users_total'] }}</div>
                    </div></div>
            </div>
            <div class="col-md-3">
                <div class="card"><div class="card-body">
                        <h6 class="text-muted">Admins</h6>
                        <div class="fs-3">{{ $summary['admins_total'] }}</div>
                    </div></div>
            </div>
            <div class="col-md-3">
                <div class="card"><div class="card-body">
                        <h6 class="text-muted">DB</h6>
                        <div class="fs-6">{{ $summary['db_connection'] }}</div>
                    </div></div>
            </div>
            <div class="col-md-3">
                <div class="card"><div class="card-body">
                        <h6 class="text-muted">Runtime</h6>
                        <div class="fs-6">PHP {{ $summary['php_version'] ?? phpversion() }}, Laravel {{ $summary['laravel_ver'] }}</div>
                    </div></div>
            </div>
        </div>
    </div>
@endsection
