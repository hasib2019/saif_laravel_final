@extends('admin.layouts.app')

@section('title', 'View Team Member')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-user me-2"></i>Team Member Details: {{ $teamMember->name }}
                    </h3>
                    <div>
                        <a href="{{ route('admin.team.edit', $teamMember->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Team Members
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Profile Image -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-image me-2"></i>Profile Image</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($teamMember->image)
                                        <img src="{{ asset($teamMember->image) }}" alt="{{ $teamMember->name }}" 
                                             class="img-fluid rounded" style="max-width: 100%; max-height: 300px;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                             style="height: 200px;">
                                            <i class="fas fa-user fa-4x text-muted"></i>
                                        </div>
                                        <p class="text-muted mt-2">No image uploaded</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Status & Settings -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Status & Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        @if($teamMember->is_active)
                                            <span class="badge bg-success ms-2">Active</span>
                                        @else
                                            <span class="badge bg-danger ms-2">Inactive</span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <strong>Sort Order:</strong>
                                        <span class="badge bg-info ms-2">{{ $teamMember->sort_order }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created:</strong><br>
                                        <small class="text-muted">{{ $teamMember->created_at->format('M d, Y H:i A') }}</small>
                                    </div>
                                    <div class="mb-0">
                                        <strong>Last Updated:</strong><br>
                                        <small class="text-muted">{{ $teamMember->updated_at->format('M d, Y H:i A') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong>Full Name:</strong>
                                                <p class="mb-0">{{ $teamMember->name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong>Designation:</strong>
                                                <p class="mb-0">{{ $teamMember->designation }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong>Email:</strong>
                                                <p class="mb-0">
                                                    @if($teamMember->email)
                                                        <a href="mailto:{{ $teamMember->email }}">{{ $teamMember->email }}</a>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong>Phone:</strong>
                                                <p class="mb-0">
                                                    @if($teamMember->phone)
                                                        <a href="tel:{{ $teamMember->phone }}">{{ $teamMember->phone }}</a>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-0">
                                                <strong>Description:</strong>
                                                <p class="mb-0 mt-2">
                                                    @if($teamMember->description)
                                                        {{ $teamMember->description }}
                                                    @else
                                                        <span class="text-muted">No description provided</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-share-alt me-2"></i>Social Links</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong><i class="fab fa-linkedin text-primary me-2"></i>LinkedIn:</strong>
                                                <p class="mb-0">
                                                    @if($teamMember->linkedin_url)
                                                        <a href="{{ $teamMember->linkedin_url }}" target="_blank" class="text-decoration-none">
                                                            {{ $teamMember->linkedin_url }}
                                                            <i class="fas fa-external-link-alt ms-1 small"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong><i class="fab fa-twitter text-info me-2"></i>Twitter:</strong>
                                                <p class="mb-0">
                                                    @if($teamMember->twitter_url)
                                                        <a href="{{ $teamMember->twitter_url }}" target="_blank" class="text-decoration-none">
                                                            {{ $teamMember->twitter_url }}
                                                            <i class="fas fa-external-link-alt ms-1 small"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong><i class="fab fa-facebook text-primary me-2"></i>Facebook:</strong>
                                                <p class="mb-0">
                                                    @if($teamMember->facebook_url)
                                                        <a href="{{ $teamMember->facebook_url }}" target="_blank" class="text-decoration-none">
                                                            {{ $teamMember->facebook_url }}
                                                            <i class="fas fa-external-link-alt ms-1 small"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-0">
                                                <strong><i class="fab fa-instagram text-danger me-2"></i>Instagram:</strong>
                                                <p class="mb-0">
                                                    @if($teamMember->instagram_url)
                                                        <a href="{{ $teamMember->instagram_url }}" target="_blank" class="text-decoration-none">
                                                            {{ $teamMember->instagram_url }}
                                                            <i class="fas fa-external-link-alt ms-1 small"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Team Members
                        </a>
                        <div>
                            <a href="{{ route('admin.team.edit', $teamMember->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Member
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash me-2"></i>Delete Member
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $teamMember->name }}</strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.team.destroy', $teamMember->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush

@push('styles')
<style>
.card-header h5 {
    color: #495057;
    font-weight: 600;
}
</style>
@endpush