@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h1 class="h5 mb-0">All Rental Requests</h1>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.reload()">Refresh</button>
        </div>

        @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif
        @if(session('error'))  <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <form method="get" class="row g-2 mb-3">
            <div class="col-12 col-md-3">
                <select name="status" class="form-select">
                    @php $current = request('status','all'); @endphp
                    <option value="all"      {{ $current==='all' ? 'selected' : '' }}>All statuses</option>
                    <option value="pending"  {{ $current==='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $current==='approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $current==='rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="reviewed" {{ $current==='reviewed' ? 'selected' : '' }}>Reviewed</option>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                       placeholder="Search student/landlord (name/email) or rental (title/location)">
            </div>
            <div class="col-12 col-md-4 d-flex gap-2">
                <button class="btn btn-primary">Search</button>
                <a href="{{ route('admin.requests.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Landlord</th>
                    <th>Rental</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($requests as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>
                            <div class="fw-semibold">{{ $r->student->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $r->student->email ?? '' }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $r->landlord->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $r->landlord->email ?? '' }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $r->rental->title ?? '—' }}</div>
                            <div class="text-muted small">{{ $r->rental->location ?? '' }}</div>
                        </td>
                        <td>
                            @php
                                $map = [
                                    'pending'  => 'warning',
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    'reviewed' => 'secondary',
                                ];
                                $badge = $map[$r->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($r->status) }}</span>
                        </td>
                        <td class="text-muted small">{{ $r->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="text-end">
                            @if($r->status !== 'reviewed')
                                <form action="{{ route('admin.requests.review',$r->id) }}" method="post" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-secondary">Mark reviewed</button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('admin.requests.destroy',$r->id) }}" method="post" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Remove this request permanently?')">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No requests found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $requests->links() }}
    </div>
@endsection
