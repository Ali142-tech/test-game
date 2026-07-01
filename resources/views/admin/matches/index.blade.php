@extends('layouts.admin')

@section('title', 'Matches')

@section('content')
<div class="admin-topbar">
    <div>
        <h1>Matches</h1>
        <p>Create matches, set ticket prices, and control how many tickets are available.</p>
    </div>
    <div class="admin-actions">
        <a href="{{ route('admin.dashboard') }}" class="btn btn--ghost">Dashboard</a>
        <a href="{{ route('admin.matches.create') }}" class="btn">Add match</a>
    </div>
</div>

<style>
    .table-actions { display: flex; gap: 8px; align-items: center; }
    .btn-edit, .btn-delete {
        display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; border-radius: 8px; border: 0;
        font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none;
    }
    .btn-edit {
        background: linear-gradient(135deg, #60a5fa, #3b82f6); color: #fff; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }
    .btn-edit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35); }
    .btn-delete {
        background: linear-gradient(135deg, #f87171, #ef4444); color: #fff; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
    }
    .btn-delete:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35); }
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); display: none;
        align-items: center; justify-content: center; z-index: 1000;
    }
    .modal-overlay.active { display: flex; }
    .modal-content {
        background: var(--panel); border-radius: 16px; padding: 32px; max-width: 400px; width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); animation: modalSlideUp 0.3s ease;
    }
    .modal-content h3 { margin: 0 0 12px; font-size: 18px; color: var(--text); }
    .modal-content p { margin: 0 0 24px; color: var(--muted); font-size: 14px; line-height: 1.5; }
    .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
    .modal-actions button { padding: 10px 16px; border-radius: 8px; border: 0; font-weight: 600; cursor: pointer; font-size: 14px; transition: all 0.2s ease; }
    .modal-btn-cancel { background: var(--line); color: var(--text); }
    .modal-btn-cancel:hover { background: var(--muted); }
    .modal-btn-confirm {
        background: linear-gradient(135deg, #f87171, #ef4444); color: #fff;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
    }
    .modal-btn-confirm:hover { box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35); }
    @keyframes modalSlideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<div class="panel">
    <table>
        <thead>
            <tr>
                <th>Match</th>
                <th>Date</th>
                <th>City</th>
                <th>Price</th>
                <th>Tickets</th>
                <th>Sold</th>
                <th>Left</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($matches as $match)
                @php
                    $sold = (int) ($match->tickets_sold ?? 0);
                    $remaining = $match->tickets_available !== null ? max(0, $match->tickets_available - $sold) : null;
                @endphp
                <tr>
                    <td>
                        <strong>{{ $match->matchupTitle() }}</strong><br>
                        <span class="muted">{{ $match->stage }}</span>
                    </td>
                    <td>{{ $match->formattedVenueDateLong() }}<br><span class="muted">{{ $match->formattedVenueKickoff() }}</span></td>
                    <td>{{ $match->city }}</td>
                    <td>{{ $match->price_from ? '$'.number_format($match->price_from) : '—' }}</td>
                    <td>{{ $match->tickets_available !== null ? number_format($match->tickets_available) : '∞' }}</td>
                    <td>{{ number_format($sold) }}</td>
                    <td>{{ $remaining !== null ? number_format($remaining) : '—' }}</td>
                    <td>
                        @if ($remaining === 0)
                            <span class="badge badge--soldout">Sold out</span>
                        @elseif ($match->is_published)
                            <span class="badge badge--published">Published</span>
                        @else
                            <span class="badge badge--draft">Draft</span>
                        @endif
                    </td>
                    <td>
                        <div class="table-actions">
                            <a class="btn-edit" href="{{ route('admin.matches.edit', $match) }}" title="Edit match">✎ Edit</a>
                            <button class="btn-delete" type="button" data-match-id="{{ $match->id }}" data-match-name="{{ $match->matchupTitle() }}" onclick="openDeleteModal(this)" title="Delete match">🗑 Delete</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No matches yet. <a class="link" href="{{ route('admin.matches.create') }}">Add your first match</a>.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal-overlay" id="deleteModal" style="display: none;">
    <div class="modal-content">
        <h3>Delete match?</h3>
        <p>Are you sure you want to delete <strong id="matchToDelete"></strong>? This action cannot be undone.</p>
        <div class="modal-actions">
            <button class="modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button class="modal-btn-confirm" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
    let matchToDelete = null;
    const deleteModal = document.getElementById('deleteModal');
    
    function openDeleteModal(button) {
        const matchId = button.dataset.matchId;
        const matchName = button.dataset.matchName;
        matchToDelete = matchId;
        document.getElementById('matchToDelete').textContent = matchName;
        deleteModal.style.display = 'flex';
    }
    
    function closeDeleteModal() {
        deleteModal.style.display = 'none';
        matchToDelete = null;
    }
    
    function confirmDelete() {
        if (matchToDelete) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/matches/${matchToDelete}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    // Close modal when clicking outside
    deleteModal.addEventListener('click', (e) => {
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && deleteModal.style.display === 'flex') {
            closeDeleteModal();
        }
    });
</script>
@endsection
