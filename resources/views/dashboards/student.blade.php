@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Dashboard Header --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h1 class="h4 fw-bold mb-2">Student Dashboard</h1>
                <p class="text-muted mb-0">
                    Welcome, {{ auth()->user()->name }}! Browse available rental listings and manage your applications.
                </p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <i class="bi bi-house-door-fill text-primary fs-1 mb-2"></i>
                            <h5 class="card-title">Browse Rentals</h5>
                            <p class="text-muted small">
                                View all available rental listings and find your next home.
                            </p>
                        </div>
                        <a href="{{ url('/rentals') }}" class="btn btn-primary mt-3 w-100">
                            View Rentals
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <i class="bi bi-envelope-paper-fill text-success fs-1 mb-2"></i>
                            <h5 class="card-title">My Requests</h5>
                            <p class="text-muted small">
                                Track the status of your rental requests and see landlord responses.
                            </p>
                        </div>
                        <a href="{{ route('student.requests.index') }}" class="btn btn-success mt-3 w-100">
                            View My Requests
                        </a>
                    </div>
                </div>
            </div>

            {{-- Optional: future feature --}}
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <i class="bi bi-person-lines-fill text-info fs-1 mb-2"></i>
                            <h5 class="card-title">Profile</h5>
                            <p class="text-muted small">
                                Update your account details and contact information.
                            </p>
                        </div>
                        <a href="#" class="btn btn-outline-info mt-3 w-100 disabled">
                            Coming Soon
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
