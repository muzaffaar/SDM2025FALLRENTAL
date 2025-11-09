@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Activity Logs</h3>
            <a href="{{ route('admin.activities.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>

        {{-- Filters --}}
        <form method="get" class="card card-body mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label">Search (action/details)</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="e.g. login, rental">
                </div>
                <div class="col-md-3">
                    <label class="form-label">User name</label>
                    <input type="text" name="user" value="{{ request('user') }}" class="form-control" placeholder="e.g. John">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Action</label>
                    <select name="action" class="form-select">
                        <option value="">— Any —</option>
                        @foreach($actions as $act)
                            <option value="{{ $act }}" @selected(request('action')===$act)>{{ $act }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date from</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date to</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Time</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Details</th>
                    <th class="text-nowrap">IP / Agent</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($logs as $i => $a)
                    @php
                        $decoded = null;
                        if (is_string($a->details) && Str::startsWith($a->details, '{')) {
                            $decoded = json_decode($a->details, true);
                        }
                    @endphp
                    <tr>
                        <td>{{ $logs->firstItem() + $i }}</td>
                        <td class="text-nowrap">{{ $a->occurred_at?->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $a->user?->name ?? '—' }}</td>
                        <td><span class="badge text-bg-info">{{ $a->action }}</span></td>
                        <td style="max-width:520px;">
                            @if($decoded)
                                <pre class="mb-0 small" style="white-space:pre-wrap; word-break:break-word;">{{ json_encode($decoded, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                            @else
                                <span class="small text-muted">{{ Str::limit((string)$a->details, 220) }}</span>
                            @endif
                        </td>
                        <td class="small text-muted" style="max-width:260px;">
                            @if($decoded)
                                {{ $decoded['ip'] ?? '' }}<br>
                                {{ Str::limit($decoded['agent'] ?? '', 80) }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No activity found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $logs->links() }}
    </div>
@endsection
