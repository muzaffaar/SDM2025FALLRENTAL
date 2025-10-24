@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Dashboard Header --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h1 class="h4 fw-bold mb-2">Landlord Dashboard</h1>
                <p class="text-muted mb-0">
                    Welcome, {{ auth()->user()->name }}! Manage your properties, rental listings, and tenant requests.
                </p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="row g-4">
            {{-- Create New Listing --}}
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <i class="bi bi-plus-square-fill text-primary fs-1 mb-2"></i>
                            <h5 class="card-title">Add New Rental</h5>
                            <p class="text-muted small">
                                Create a new rental listing for students to view and apply.
                            </p>
                        </div>
                        <a href="{{ route('landlord.rentals.create') }}" class="btn btn-primary mt-3 w-100">
                            Create Listing
                        </a>
                    </div>
                </div>
            </div>

            {{-- My Listings --}}
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <i class="bi bi-building-check text-success fs-1 mb-2"></i>
                            <h5 class="card-title">My Rentals</h5>
                            <p class="text-muted small">
                                View, edit, or remove your existing rental listings.
                            </p>
                        </div>
                        <a href="{{ url('/landlord/rentals') }}" class="btn btn-success mt-3 w-100">
                            View My Listings
                        </a>
                    </div>
                </div>
            </div>

            {{-- Tenant Requests --}}
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <i class="bi bi-envelope-paper-fill text-warning fs-1 mb-2"></i>
                            <h5 class="card-title">Tenant Requests</h5>
                            <p class="text-muted small">
                                Check rental requests from interested students.
                            </p>
                        </div>
                        <a href="{{ url('/landlord/requests') }}" class="btn btn-warning text-white mt-3 w-100">
                            View Requests
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
