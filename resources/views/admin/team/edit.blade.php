@extends('admin.layouts.app')

@section('title', 'Edit Team Member')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit me-2"></i>Edit Team Member: {{ $teamMember->name }}
                    </h3>
                    <div>
                        <a href="{{ route('admin.team.show', $teamMember) }}" class="btn btn-info">
                            <i class="fas fa-eye me-2"></i>View
                        </a>
                        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Team Members
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.team.update', $teamMember) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
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
                                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" 
                                                           value="{{ old('name', $teamMember->name) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="designation" name="designation" 
                                                           value="{{ old('designation', $teamMember->designation) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" 
                                                           value="{{ old('email', $teamMember->email) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" 
                                                           value="{{ old('phone', $teamMember->phone) }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="4" 
                                                              placeholder="Brief description about the team member...">{{ old('description', $teamMember->description) }}</textarea>
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
                                                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                                    <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" 
                                                           value="{{ old('linkedin_url', $teamMember->linkedin_url) }}" placeholder="https://linkedin.com/in/username">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="twitter_url" class="form-label">Twitter URL</label>
                                                    <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                                                           value="{{ old('twitter_url', $teamMember->twitter_url) }}" placeholder="https://twitter.com/username">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="facebook_url" class="form-label">Facebook URL</label>
                                                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                                                           value="{{ old('facebook_url', $teamMember->facebook_url) }}" placeholder="https://facebook.com/username">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="instagram_url" class="form-label">Instagram URL</label>
                                                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" 
                                                           value="{{ old('instagram_url', $teamMember->instagram_url) }}" placeholder="https://instagram.com/username">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Image Upload -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-image me-2"></i>Profile Image</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            @if($teamMember->image)
                                                <div class="mb-3">
                                                    <img src="{{ asset($teamMember->image) }}" alt="{{ $teamMember->name }}" 
                                                         class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                    <div class="mt-2">
                                                        <small class="text-muted">Current image</small>
                                                    </div>
                                                </div>
                                            @endif
                                            <div id="imagePreview" class="mb-3" style="display: none;">
                                                <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                <div class="mt-2">
                                                    <small class="text-muted">New image preview</small>
                                                </div>
                                            </div>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                            <small class="text-muted">Leave empty to keep current image. Recommended size: 400x400px</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label">Sort Order</label>
                                            <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                                   value="{{ old('sort_order', $teamMember->sort_order) }}" min="0">
                                            <small class="text-muted">Lower numbers appear first</small>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                                       {{ old('is_active', $teamMember->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Active Status
                                                </label>
                                            </div>
                                            <small class="text-muted">Only active members will be displayed on the website</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Member Info -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-info me-2"></i>Member Info</h5>
                                    </div>
                                    <div class="card-body">
                                        <small class="text-muted">
                                            <strong>Created:</strong> {{ $teamMember->created_at->format('M d, Y H:i') }}<br>
                                            <strong>Updated:</strong> {{ $teamMember->updated_at->format('M d, Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Team Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
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