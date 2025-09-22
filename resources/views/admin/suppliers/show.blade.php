@extends('admin.layouts.app')

@section('title', 'Supplier Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Supplier Details</h5>
                    <div>
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h3 class="text-primary">{{ $supplier->name }}</h3>
                            <p class="text-muted mb-2">
                                <strong>Slug:</strong> {{ $supplier->slug }}
                            </p>
                            <div class="d-flex align-items-center mb-3">
                                @if($supplier->is_active)
                                    <span class="badge bg-success me-2">Active</span>
                                @else
                                    <span class="badge bg-secondary me-2">Inactive</span>
                                @endif
                                <small class="text-muted">Sort Order: {{ $supplier->sort_order }}</small>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted">
                                Created: {{ $supplier->created_at->format('M d, Y') }}<br>
                                Updated: {{ $supplier->updated_at->format('M d, Y') }}
                            </small>
                        </div>
                    </div>

                    @if($supplier->short_description)
                        <div class="mb-4">
                            <h6 class="text-secondary">Short Description</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $supplier->short_description }}
                            </div>
                        </div>
                    @endif

                    @if($supplier->description)
                        <div class="mb-4">
                            <h6 class="text-secondary">Full Description</h6>
                            <div class="border p-3 rounded">
                                {!! nl2br(e($supplier->description)) !!}
                            </div>
                        </div>
                    @endif

                    @if($supplier->images && is_array($supplier->images) && count($supplier->images) > 0)
                        <div class="mb-4">
                            <h6 class="text-secondary">Images</h6>
                            <div class="row">
                                @foreach($supplier->images as $image)
                                    <div class="col-md-4 col-sm-6 mb-3">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Supplier Image">
                                            <div class="card-body p-2">
                                                <a href="{{ asset('storage/' . $image) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                                    <i class="fas fa-external-link-alt me-1"></i>View Full Size
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        @if($supplier->pdf_file)
                            <div class="col-md-6 mb-4">
                                <h6 class="text-secondary">PDF Document</h6>
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                        <h6>PDF Document</h6>
                                        <a href="{{ asset('storage/' . $supplier->pdf_file) }}" target="_blank" class="btn btn-outline-danger">
                                            <i class="fas fa-download me-1"></i>Download PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($supplier->video_file)
                            <div class="col-md-6 mb-4">
                                <h6 class="text-secondary">Video File</h6>
                                <div class="card">
                                    <div class="card-body">
                                        <video controls class="w-100" style="max-height: 300px;">
                                            <source src="{{ asset('storage/' . $supplier->video_file) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <div class="text-center mt-2">
                                            <a href="{{ asset('storage/' . $supplier->video_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-external-link-alt me-1"></i>Open in New Tab
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($supplier->youtube_link)
                        <div class="mb-4">
                            <h6 class="text-secondary">YouTube Video</h6>
                            <div class="card">
                                <div class="card-body">
                                    @php
                                        $youtube_id = '';
                                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $supplier->youtube_link, $matches)) {
                                            $youtube_id = $matches[1];
                                        }
                                    @endphp
                                    
                                    @if($youtube_id)
                                        <div class="ratio ratio-16x9">
                                            <iframe src="https://www.youtube.com/embed/{{ $youtube_id }}" 
                                                    title="YouTube video player" 
                                                    frameborder="0" 
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                    allowfullscreen>
                                            </iframe>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fab fa-youtube fa-3x text-danger mb-3"></i>
                                            <h6>YouTube Video</h6>
                                            <a href="{{ $supplier->youtube_link }}" target="_blank" class="btn btn-outline-danger">
                                                <i class="fas fa-external-link-alt me-1"></i>Watch on YouTube
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit Supplier
                        </a>
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-1"></i>Delete Supplier
                        </button>
                        
                        <hr>
                        
                        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Add New Supplier
                        </a>
                        
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list me-1"></i>All Suppliers
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Supplier Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary">{{ $supplier->images && is_array($supplier->images) ? count($supplier->images) : 0 }}</h4>
                                <small class="text-muted">Images</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info">{{ $supplier->sort_order }}</h4>
                            <small class="text-muted">Sort Order</small>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <i class="fas fa-file-pdf fa-2x {{ $supplier->pdf_file ? 'text-success' : 'text-muted' }}"></i>
                            <br><small>PDF</small>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-video fa-2x {{ $supplier->video_file ? 'text-success' : 'text-muted' }}"></i>
                            <br><small>Video</small>
                        </div>
                        <div class="col-4">
                            <i class="fab fa-youtube fa-2x {{ $supplier->youtube_link ? 'text-success' : 'text-muted' }}"></i>
                            <br><small>YouTube</small>
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
                <p>Are you sure you want to delete the supplier "<strong>{{ $supplier->name }}</strong>"?</p>
                <p class="text-danger"><small><i class="fas fa-exclamation-triangle me-1"></i>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete Supplier
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection