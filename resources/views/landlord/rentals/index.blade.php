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
            <h4 class="fw-bold mb-0">Tenant Requests</h4>
            <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        @if($requests->count())
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Rental Title</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $req)
                                <tr>
                                    <td>{{ $req->student->name ?? 'N/A' }}</td>
                                    <td>{{ $req->rental->title ?? 'N/A' }}</td>
                                    <td class="text-muted">{{ $req->message ?? '—' }}</td>
                                    <td>
                                        <span class="badge
                                            @if($req->status === 'approved') bg-success
                                            @elseif($req->status === 'rejected') bg-danger
                                            @else bg-warning text-dark @endif">
                                            {{ ucfirst($req->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        @if($req->status === 'pending')
                                            <div class="btn-group" role="group">
                                                <form action="{{ route('landlord.requests.update', $req->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="action" value="approve">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bi bi-check2-circle"></i> Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('landlord.requests.update', $req->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-x-circle"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted small">No actions available</span>
                                        @endif
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
                No rental requests found.
            </div>
        @endif

    </div>
@endsection
