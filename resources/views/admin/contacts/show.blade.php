@extends('admin.layouts.app')

@section('title', 'Contact Message Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-envelope me-2"></i>Contact Message Details
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.contacts.index') }}">Contact Messages</a>
                            </li>
                            <li class="breadcrumb-item active">Message Details</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Messages
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Message Details -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-comment-alt me-2"></i>{{ $contact->subject }}
                            </h5>
                            <div>
                                @if($contact->is_read)
                                    <span class="badge bg-success">
                                        <i class="fas fa-envelope-open"></i> Read
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-envelope"></i> Unread
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Message Content -->
                            <div class="message-content">
                                <div class="mb-4 p-3 bg-light rounded">
                                    <p class="mb-0" style="white-space: pre-wrap; line-height: 1.6;">{{ $contact->message }}</p>
                                </div>
                            </div>

                            <!-- Message Metadata -->
                            <div class="row text-muted small">
                                <div class="col-md-6">
                                    <strong>Received:</strong> {{ $contact->created_at->format('F d, Y \\a\\t H:i') }}
                                </div>
                                @if($contact->is_read && $contact->read_at)
                                    <div class="col-md-6">
                                        <strong>Read:</strong> {{ $contact->read_at->format('F d, Y \\a\\t H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Reply Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-reply me-2"></i>Quick Reply
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> This will open your default email client to reply to {{ $contact->name }}.
                            </div>
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                               class="btn btn-primary">
                                <i class="fas fa-reply me-2"></i>Reply via Email
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Contact Information -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>Contact Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="contact-info">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Name</label>
                                    <div class="fw-bold">{{ $contact->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Email</label>
                                    <div>
                                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                            {{ $contact->email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Subject</label>
                                    <div>{{ $contact->subject }}</div>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label text-muted small">Message Length</label>
                                    <div>{{ strlen($contact->message) }} characters</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cogs me-2"></i>Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if(!$contact->is_read)
                                    <button type="button" class="btn btn-success" onclick="markAsRead({{ $contact->id }})">
                                        <i class="fas fa-check me-2"></i>Mark as Read
                                    </button>
                                @else
                                    <button type="button" class="btn btn-warning" onclick="markAsUnread({{ $contact->id }})">
                                        <i class="fas fa-undo me-2"></i>Mark as Unread
                                    </button>
                                @endif
                                
                                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-reply me-2"></i>Reply via Email
                                </a>
                                
                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this message? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-trash me-2"></i>Delete Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Message Statistics -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2"></i>Message Info
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <div class="h4 mb-1 text-primary">{{ $contact->id }}</div>
                                        <div class="small text-muted">Message ID</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="h4 mb-1 text-info">{{ $contact->created_at->diffForHumans() }}</div>
                                    <div class="small text-muted">Received</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
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
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}
</script>
@endpush
@endsection