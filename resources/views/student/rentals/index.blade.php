@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Page Title --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Available Rentals</h2>
        </div>

        {{-- Filters --}}
        <form method="GET" class="bg-light border rounded p-3 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="location" class="form-label fw-semibold">Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter location"
                           value="{{ request('location') }}"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="min_price" class="form-label fw-semibold">Min Price</label>
                    <input type="number" id="min_price" name="min_price" placeholder="e.g. 200"
                           value="{{ request('min_price') }}"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="max_price" class="form-label fw-semibold">Max Price</label>
                    <input type="number" id="max_price" name="max_price" placeholder="e.g. 1200"
                           value="{{ request('max_price') }}"
                           class="form-control">
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        {{-- Rentals Grid --}}
        @if($rentals->count())
            <div class="row g-4">
                @foreach($rentals as $rental)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100 border-0">

                            {{-- Carousel for Multiple Images --}}
                            @if($rental->images && $rental->images->count())
                                <div id="rentalCarousel{{ $rental->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($rental->images as $key => $img)
                                            <div class="carousel-item @if($key == 0) active @endif">
                                                <img src="{{ asset('storage/'.$img->image_path) }}"
                                                     class="d-block w-100 rounded-top"
                                                     alt="rental image"
                                                     style="height: 220px; object-fit: cover;">
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
                                <img src="{{ asset('images/default.jpg') }}" class="card-img-top rounded-top"
                                     alt="default rental image"
                                     style="height: 220px; object-fit: cover;">
                            @endif

                            {{-- Card Body --}}
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title fw-bold">{{ $rental->title }}</h5>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-geo-alt-fill text-danger"></i>
                                        {{ $rental->location }}
                                    </p>
                                    <p class="text-primary fw-semibold mb-2">
                                        ${{ number_format($rental->price, 2) }}
                                    </p>
                                    <p class="text-secondary small mb-3">
                                        {{ Str::limit($rental->description, 80) }}
                                    </p>
                                </div>

                                {{-- View Details --}}
                                <div class="mt-auto">
                                    <a href="{{ url('/rentals/'.$rental->id) }}" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-info-circle me-1"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $rentals->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info mt-4" role="alert">
                No rentals found for your filters. Try adjusting your search.
            </div>
        @endif

    </div>
@endsection
