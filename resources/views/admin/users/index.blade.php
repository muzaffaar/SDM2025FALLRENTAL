@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3">Manage Users</h1>

        @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <form class="row g-2 mb-3" method="get">
            <div class="col-auto">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name/email/role">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td><span class="badge bg-secondary text-uppercase">{{ $u->role }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="post" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user permanently?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>
@endsection
