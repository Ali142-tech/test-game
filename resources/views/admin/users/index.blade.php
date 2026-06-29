@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="admin-topbar">
    <div>
        <h1>Users</h1>
        <p>All registered customers on your site and their ticket activity.</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card stat-card--blue">
        <div class="stat-card__label">Total users</div>
        <div class="stat-card__value">{{ number_format($stats['total']) }}</div>
        <div class="stat-card__hint">Excludes admin accounts</div>
    </div>
    <div class="stat-card stat-card--green">
        <div class="stat-card__label">Buyers</div>
        <div class="stat-card__value">{{ number_format($stats['with_orders']) }}</div>
        <div class="stat-card__hint">Users with paid tickets</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__label">New this month</div>
        <div class="stat-card__value">{{ number_format($stats['new_this_month']) }}</div>
    </div>
</div>

<div class="panel">
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Phone</th>
                <th>Tickets bought</th>
                <th>Total spent</th>
                <th>Orders</th>
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>
                        <strong>{{ $user->name }}</strong><br>
                        <span class="muted">{{ $user->email }}</span>
                    </td>
                    <td>{{ $user->formattedPhone() ?? '—' }}</td>
                    <td>{{ number_format((int) $user->tickets_bought) }}</td>
                    <td>${{ number_format(((int) $user->total_spent) / 100, 0) }}</td>
                    <td>{{ number_format($user->orders_count) }}</td>
                    <td>{{ $user->created_at->format('M j, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No users registered yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($users->hasPages())
        <div class="pagination">
            @if ($users->onFirstPage())
                <span>&laquo; Prev</span>
            @else
                <a href="{{ $users->previousPageUrl() }}">&laquo; Prev</a>
            @endif

            <span class="current">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</span>

            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}">Next &raquo;</a>
            @else
                <span>Next &raquo;</span>
            @endif
        </div>
    @endif
</div>
@endsection
