@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">My Rentals</h4>
            <a href="{{ route('landlord.rentals.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add New
            </a>
        </div>

        {{-- Filter Form --}}
        <form method="GET" class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="keyword" class="form-label fw-semibold">Keyword</label>
                        <input type="text" id="keyword" name="keyword" value="{{ request('keyword') }}"
                               placeholder="Search title or description" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label for="location" class="form-label fw-semibold">Location</label>
                        <input type="text" id="location" name="location" value="{{ request('location') }}"
                               placeholder="e.g. Debrecen" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label for="min_price" class="form-label fw-semibold">Min Price</label>
                        <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}"
                               placeholder="0" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label for="max_price" class="form-label fw-semibold">Max Price</label>
                        <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}"
                               placeholder="1000" class="form-control">
                    </div>

                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel-fill me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Rentals as Cards --}}
        @if($rentals->count())
            <div class="row g-4">
                @foreach($rentals as $rental)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100 border-0">

                            {{-- Image Carousel --}}
                            @if($rental->images->count())
                                <div id="carouselRental{{ $rental->id }}" class="carousel slide" data-bs-ride="carousel">
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
                                                data-bs-target="#carouselRental{{ $rental->id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselRental{{ $rental->id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    @endif
                                </div>
                            @else
                                <img src="{{ asset('images/default.jpg') }}" class="card-img-top"
                                     alt="no image" style="height: 220px; object-fit: cover;">
                            @endif

                            {{-- Card Body --}}
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title fw-semibold mb-1">{{ $rental->title }}</h5>
                                    <p class="text-muted small mb-1"><i class="bi bi-geo-alt"></i> {{ $rental->location }}</p>
                                    <p class="fw-bold text-primary mb-2">${{ number_format($rental->price, 2) }}</p>
                                    <span class="badge
                                    @if($rental->status === 'available') bg-success
                                    @elseif($rental->status === 'rented') bg-secondary
                                    @else bg-warning @endif">
                                    {{ ucfirst($rental->status) }}
                                </span>
                                </div>

                                {{-- Actions --}}
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('landlord.rentals.edit', $rental->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $rental->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Delete Modal --}}
                    <div class="modal fade" id="deleteModal{{ $rental->id }}" tabindex="-1"
                         aria-labelledby="deleteModalLabel{{ $rental->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>{{ $rental->title }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('landlord.rentals.destroy', $rental->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info mt-4" role="alert">
                No rentals found matching your filters.
            </div>
        @endif
    </div>
@endsection
