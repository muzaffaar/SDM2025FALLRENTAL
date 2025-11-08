@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3">Edit User #{{ $user->id }}</h1>

        <form method="post" action="{{ route('admin.users.update', $user) }}" class="card card-body">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name',$user->name) }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email',$user->email) }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror">
                    @foreach(['admin','student','landlord'] as $r)
                        <option value="{{ $r }}" @selected(old('role',$user->role)===$r)>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
