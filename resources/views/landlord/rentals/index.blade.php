@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Flash messages --}}
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
                        <input type="text" id="keyword" name="keyword"
                               value="{{ request('keyword') }}"
                               placeholder="Search title or description"
                               class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label for="location" class="form-label fw-semibold">Location</label>
                        <input type="text" id="location" name="location"
                               value="{{ request('location') }}"
                               placeholder="e.g. Debrecen"
                               class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label for="min_price" class="form-label fw-semibold">Min Price</label>
                        <input type="number" id="min_price" name="min_price"
                               value="{{ request('min_price') }}"
                               placeholder="0"
                               class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label for="max_price" class="form-label fw-semibold">Max Price</label>
                        <input type="number" id="max_price" name="max_price"
                               value="{{ request('max_price') }}"
                               placeholder="1000"
                               class="form-control">
                    </div>

                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel-fill me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Rentals Table --}}
        @if($rentals->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rentals as $rental)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/'.$rental->image_path) }}"
                                     alt="image"
                                     width="70" height="70"
                                     class="rounded" style="object-fit: cover;">
                            </td>
                            <td>{{ $rental->title }}</td>
                            <td>{{ $rental->location }}</td>
                            <td>${{ number_format($rental->price, 2) }}</td>
                            <td>
                                <span class="badge
                                    @if($rental->status === 'available') bg-success
                                    @elseif($rental->status === 'rented') bg-secondary
                                    @else bg-warning @endif">
                                    {{ ucfirst($rental->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('landlord.rentals.edit', $rental->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <!-- Delete Button trigger modal -->
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $rental->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $rental->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $rental->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $rental->id }}">Confirm Deletion</h5>
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
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info mt-4" role="alert">
                No rentals found matching your filters.
            </div>
        @endif

    </div>
@endsection
