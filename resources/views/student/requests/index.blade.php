@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 fw-bold mb-0">My Rental Requests</h2>
            <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        {{-- Requests Table --}}
        @if ($requests->count())
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Rental Title</th>
                                <th>Landlord</th>
                                <th>Status</th>
                                <th>Message</th>
                                <th>Requested At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $request->rental->title ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $request->rental->landlord->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match($request->status) {
                                                'approved' => 'bg-success',
                                                'rejected' => 'bg-danger',
                                                default => 'bg-warning text-dark',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">
                                        {{ $request->message ?? '—' }}
                                    </td>
                                    <td class="text-secondary">
                                        {{ $request->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info mt-4" role="alert">
                You haven't submitted any rental requests yet.
            </div>
        @endif

    </div>
@endsection
