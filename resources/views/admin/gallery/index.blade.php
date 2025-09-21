@extends('admin.layouts.app')

@section('title', 'Gallery Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Gallery Management</h3>
                    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Image
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($galleries->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="80">Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th width="100">Sort Order</th>
                                        <th width="80">Status</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($galleries as $gallery)
                                        <tr>
                                            <td>
                                                @if($gallery->image_path)
                                                    <img src="{{ asset($gallery->image_path) }}" 
                                                         alt="{{ $gallery->title }}" 
                                                         class="img-thumbnail" 
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $gallery->title }}</td>
                                            <td>{{ Str::limit($gallery->description, 50) }}</td>
                                            <td>{{ $gallery->sort_order }}</td>
                                            <td>
                                                <form action="{{ route('admin.gallery.toggle-status', $gallery) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $gallery->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                        {{ $gallery->is_active ? 'Active' : 'Inactive' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.gallery.edit', $gallery) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.gallery.destroy', $gallery) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this gallery item?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $galleries->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No gallery items found</h5>
                            <p class="text-muted">Start by adding your first gallery image.</p>
                            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add First Image
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection