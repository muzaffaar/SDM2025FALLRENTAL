{{-- resources/views/admin/rentals/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3">All Rentals</h1>

        @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <form method="get" class="row g-2 mb-3">
            <div class="col-auto">
                <input name="search" value="{{ request('search') }}" class="form-control" placeholder="Search title/address/city/status">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>City</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($rentals as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->title }}</td>
                        <td>{{ $r->location }}</td>
                        <td>USD {{ number_format($r->price ?? 0) }}</td>
                        <td>
                        <span class="badge {{ $r->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($r->status) }}
                        </span>
                        </td>
                        <td class="text-end">
                            {{-- Approve --}}
                            @if($r->status !== 'active')
                                <form action="{{ route('admin.rentals.updateStatus',$r->id) }}" method="post" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="active">
                                    <button class="btn btn-sm btn-outline-success">Approve</button>
                                </form>
                            @endif

                            {{-- Deactivate --}}
                            @if($r->status !== 'inactive')
                                <form action="{{ route('admin.rentals.updateStatus',$r->id) }}" method="post" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="inactive">
                                    <button class="btn btn-sm btn-outline-warning">Deactivate</button>
                                </form>
                            @endif

                            {{-- Hard delete --}}
                            <form action="{{ route('admin.rentals.destroy',$r->id) }}" method="post" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this rental permanently?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No rentals found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $rentals->links() }}
    </div>
@endsection
