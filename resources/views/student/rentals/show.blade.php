@extends('layouts.app')

@section('content')
    <div class="container py-4 w-50">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">{{ $rental->title }}</h2>
            <a href="{{ route('student.rentals.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Rentals
            </a>
        </div>

        {{-- Rental Details Card --}}
        <div class="card shadow-sm mb-4 border-0">

            {{-- Carousel --}}
            @if($rental->images && $rental->images->count())
                <div id="rentalCarousel{{ $rental->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($rental->images as $key => $img)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <img src="{{ asset('storage/'.$img->image_path) }}"
                                     class="d-block w-100 rounded-top"
                                     alt="{{ $rental->title }}"
                                     style="height: 400px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                    @if($rental->images->count() > 1)
                        <button class="carousel-control-prev" type="button"
                                data-bs-target="#rentalCarousel{{ $rental->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button"
                                data-bs-target="#rentalCarousel{{ $rental->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            @else
                <img src="{{ asset('images/default.jpg') }}"
                     class="card-img-top rounded-top"
                     alt="Default image"
                     style="height: 400px; object-fit: cover;">
            @endif

            {{-- Rental Info --}}
            <div class="card-body">
                <h3 class="card-title fw-bold mb-2">{{ $rental->title }}</h3>
                <p class="text-muted mb-2">
                    <i class="bi bi-geo-alt-fill text-danger"></i> {{ $rental->location }}
                </p>
                <p class="h5 text-primary fw-semibold mb-3">${{ number_format($rental->price, 2) }}</p>

                <p class="text-secondary mb-4">{{ $rental->description }}</p>

                <div class="small text-muted">
                    <p class="mb-1">
                        <i class="bi bi-person-fill"></i>
                        Landlord: {{ $rental->landlord->name ?? 'Unknown' }}
                    </p>
                    <p class="mb-1">
                        <i class="bi bi-calendar3"></i>
                        Listed on: {{ $rental->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Rental Request Form --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3">Send Rental Request</h5>

                <form action="{{ route('student.rentals.request', $rental->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label fw-semibold">Message to Landlord (optional)</label>
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
