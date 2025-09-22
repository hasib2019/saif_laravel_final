@extends('admin.layouts.app')

@section('title', 'Manage Suppliers')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Manage Suppliers</h5>
                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Add New Supplier
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.suppliers.index') }}" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" 
                                       placeholder="Search suppliers..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.suppliers.index') }}" class="d-flex justify-content-end">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <select name="status" class="form-select me-2" style="width: auto;" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    @if($suppliers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Short Description</th>
                                        <th>Images</th>
                                        <th>Files</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suppliers as $supplier)
                                        <tr>
                                            <td>{{ $supplier->id }}</td>
                                            <td>
                                                <strong>{{ $supplier->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $supplier->slug }}</small>
                                            </td>
                                            <td>
                                                @if($supplier->short_description)
                                                    {{ Str::limit($supplier->short_description, 50) }}
                                                @else
                                                    <span class="text-muted">No description</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($supplier->images && is_array($supplier->images) && count($supplier->images) > 0)
                                                    <span class="badge bg-info">{{ count($supplier->images) }} images</span>
                                                @else
                                                    <span class="text-muted">No images</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-1">
                                                    @if($supplier->pdf_file)
                                                        <span class="badge bg-danger">PDF</span>
                                                    @endif
                                                    @if($supplier->video_file)
                                                        <span class="badge bg-warning">Video</span>
                                                    @endif
                                                    @if($supplier->youtube_link)
                                                        <span class="badge bg-danger">YouTube</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $supplier->sort_order }}</span>
                                            </td>
                                            <td>
                                                @if($supplier->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $supplier->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.suppliers.show', $supplier) }}" 
                                                       class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.suppliers.edit', $supplier) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}" 
                                                          class="d-inline" onsubmit="return confirm('Are you sure you want to delete this supplier?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
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

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="text-muted">
                                    Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} results
                                </small>
                            </div>
                            <div>
                                {{ $suppliers->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No suppliers found</h5>
                            <p class="text-muted">
                                @if(request('search') || request('status'))
                                    No suppliers match your search criteria.
                                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-link">Clear filters</a>
                                @else
                                    Get started by adding your first supplier.
                                @endif
                            </p>
                            @if(!request('search') && !request('status'))
                                <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Add First Supplier
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection