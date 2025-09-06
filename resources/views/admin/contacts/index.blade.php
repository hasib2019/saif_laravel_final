@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-envelope me-2"></i>Contact Messages
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-2">{{ $unreadCount }} unread</span>
                        @endif
                    </h3>
                </div>

                <div class="card-body">
                    <!-- Filters and Search -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.contacts.index') }}" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" 
                                       placeholder="Search messages..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.contacts.index') }}" 
                                   class="btn {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    All
                                </a>
                                <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" 
                                   class="btn {{ request('status') === 'unread' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Unread ({{ $unreadCount }})
                                </a>
                                <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" 
                                   class="btn {{ request('status') === 'read' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Read
                                </a>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Bulk Actions -->
                    <form id="bulkActionForm" method="POST" action="{{ route('admin.contacts.bulk-action') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <select name="action" class="form-select me-2" style="width: auto;">
                                        <option value="">Bulk Actions</option>
                                        <option value="mark_read">Mark as Read</option>
                                        <option value="mark_unread">Mark as Unread</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <button type="submit" class="btn btn-secondary" onclick="return confirmBulkAction()">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Messages Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th>Status</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contacts as $contact)
                                        <tr class="{{ !$contact->is_read ? 'table-warning' : '' }}">
                                            <td>
                                                <input type="checkbox" name="contact_ids[]" value="{{ $contact->id }}" 
                                                       class="form-check-input contact-checkbox">
                                            </td>
                                            <td>
                                                @if($contact->is_read)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-envelope-open"></i> Read
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-envelope"></i> Unread
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $contact->name }}</strong>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                                    {{ $contact->email }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.contacts.show', $contact) }}" 
                                                   class="text-decoration-none">
                                                    {{ Str::limit($contact->subject, 50) }}
                                                </a>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $contact->created_at->format('M d, Y H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.contacts.show', $contact) }}" 
                                                       class="btn btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(!$contact->is_read)
                                                        <button type="button" class="btn btn-outline-success" 
                                                                onclick="markAsRead({{ $contact->id }})" title="Mark as Read">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-outline-warning" 
                                                                onclick="markAsUnread({{ $contact->id }})" title="Mark as Unread">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    @endif
                                                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" 
                                                          class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                                    <p class="mb-0">No contact messages found.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination -->
                    @if($contacts->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $contacts->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Bulk action confirmation
function confirmBulkAction() {
    const selectedCheckboxes = document.querySelectorAll('.contact-checkbox:checked');
    const action = document.querySelector('select[name="action"]').value;
    
    if (!action) {
        alert('Please select an action.');
        return false;
    }
    
    if (selectedCheckboxes.length === 0) {
        alert('Please select at least one message.');
        return false;
    }
    
    const actionText = action.replace('_', ' ');
    return confirm(`Are you sure you want to ${actionText} ${selectedCheckboxes.length} selected message(s)?`);
}

// Mark as read/unread via AJAX
function markAsRead(contactId) {
    fetch(`/admin/contacts/${contactId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function markAsUnread(contactId) {
    fetch(`/admin/contacts/${contactId}/mark-unread`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endpush
@endsection