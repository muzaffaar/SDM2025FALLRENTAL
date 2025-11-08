@extends('layouts.app')

@section('head')
    {{-- Auto-refresh every 5 minutes --}}
    <meta http-equiv="refresh" content="300">
@endsection

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h1 class="h4 mb-0">Admin Dashboard</h1>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.reload()">
                Refresh
            </button>
        </div>

        {{-- Stat cards --}}
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Total Users</div>
                        <div class="display-6 fw-semibold">{{ $userCount }}</div>
                        <div class="text-muted small">New today: {{ $newUsersToday }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Total Rentals</div>
                        <div class="display-6 fw-semibold">{{ $rentalCount }}</div>
                        <div class="text-muted small">New today: {{ $newRentalsToday }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Pending Requests</div>
                        <div class="display-6 fw-semibold">{{ $pendingRequests }}</div>
                        <div class="text-muted small">Approved: {{ $approvedRequests }} · Rejected: {{ $rejectedRequests }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Active Rentals</div>
                        <div class="display-6 fw-semibold">{{ $rentalsActive }}</div>
                        <div class="text-muted small">Available: {{ $rentalsAvailable }} · Rented: {{ $rentalsRented }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Inactive Rentals</div>
                        <div class="display-6 fw-semibold">{{ $rentalsInactive }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="row g-3">
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Rentals by Status</h6>
                        <canvas id="rentalsChart" height="130"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Requests by Status</h6>
                        <canvas id="requestsChart" height="130"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-muted small mt-3 mb-0">
            Updated at {{ now()->format('Y-m-d H:i:s') }}
        </p>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Rentals chart
            new Chart(document.getElementById('rentalsChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Active','Inactive','Available','Rented'],
                    datasets: [{
                        data: [
                            {{ $rentalsActive }},
                            {{ $rentalsInactive }},
                            {{ $rentalsAvailable }},
                            {{ $rentalsRented }},
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });

            // Requests chart
            new Chart(document.getElementById('requestsChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Pending','Approved','Rejected'],
                    datasets: [{
                        data: [
                            {{ $pendingRequests }},
                            {{ $approvedRequests }},
                            {{ $rejectedRequests }},
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });

            // JS refresh safeguard (5 minutes)
            setInterval(() => location.reload(), 300000);
        });
    </script>
@endpush
