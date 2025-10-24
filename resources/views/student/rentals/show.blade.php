@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 fw-bold mb-0">My Rental Requests</h2>
            <a href="{{ route('student.rentals.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Rentals List
            </a>
        </div>

        {{-- Rental Details --}}
        <div class="card shadow-sm mb-4">
            <div class="row g-0">
                <div class="col-md-5">
                    <img src="{{ asset('storage/' . $rental->image_path) }}"
                         alt="{{ $rental->title }}"
                         class="img-fluid rounded-start w-100 h-100"
                         style="object-fit: cover;">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h3 class="card-title fw-bold mb-2">{{ $rental->title }}</h3>
                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt-fill text-danger"></i> {{ $rental->location }}
                        </p>
                        <p class="h5 text-primary fw-semibold mb-3">${{ number_format($rental->price, 2) }}</p>

                        <p class="text-secondary mb-3">{{ $rental->description }}</p>

                        <p class="small text-muted mb-1">
                            <i class="bi bi-person-fill"></i>
                            Landlord: {{ $rental->landlord->name ?? 'Unknown' }}
                        </p>

                        <p class="small text-muted mb-1">
                            <i class="bi bi-calendar3"></i>
                            Listed on: {{ $rental->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rental Request Form --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Send Rental Request</h5>

                <form action="{{ route('student.rentals.request', $rental->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label fw-semibold">
                            Message to Landlord (optional)
                        </label>
                        <textarea name="message" id="message" rows="3"
                                  placeholder="Write a message to the landlord..."
                                  class="form-control"></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send-fill me-1"></i> Request Rental
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
