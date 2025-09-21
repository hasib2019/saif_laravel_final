@extends('admin.layouts.app')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
            <p class="mb-0 text-muted">Order #{{ $order->order_number }}</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
                    <span class="badge bg-{{ $order->getStatusBadgeColor() }} fs-6 px-3 py-2">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Order Number</h6>
                            <p class="fw-bold">{{ $order->order_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Order Date</h6>
                            <p class="fw-bold">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Status</h6>
                            <span class="badge bg-{{ $order->getStatusBadgeColor() }} fs-6">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Total Amount</h6>
                            <p class="fw-bold text-success fs-5">${{ $order->getFormattedTotalAmount() }}</p>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Order Notes</h6>
                            <div class="alert alert-info">
                                <i class="fas fa-sticky-note me-2"></i>
                                {{ $order->notes }}
                            </div>
                        </div>
                    @endif

                    <!-- Status Update Form -->
                    <div class="border-top pt-3">
                        <h6 class="text-muted mb-3">Update Order Status</h6>
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-6">
                                <select class="form-control" name="status" required>
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                        <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded">
                            <div class="d-flex align-items-center">
                                @if($item->product_image)
                                    <img src="{{ asset('storage/' . $item->product_image) }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="img-thumbnail me-3" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-white d-flex align-items-center justify-content-center me-3" 
                                         style="width: 80px; height: 80px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                    <small class="text-muted">SKU: {{ $item->product_sku }}</small><br>
                                    <small class="text-muted">Quantity: {{ $item->quantity }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ $item->formatted_total_price }}</div>
                                <small class="text-muted">{{ $item->formatted_unit_price }} each</small>
                            </div>
                        </div>
                    @endforeach

                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Total Amount</h5>
                            <h4 class="mb-0 text-success fw-bold">${{ $order->getFormattedTotalAmount() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Shipping Information -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Name</h6>
                        <p class="fw-bold mb-0">{{ $order->customer_name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Email</h6>
                        <p class="fw-bold mb-0">
                            <a href="mailto:{{ $order->customer_email }}" class="text-decoration-none">
                                {{ $order->customer_email }}
                            </a>
                        </p>
                    </div>
                    
                    <div class="mb-0">
                        <h6 class="text-muted mb-1">Phone</h6>
                        <p class="fw-bold mb-0">
                            <a href="tel:{{ $order->customer_phone }}" class="text-decoration-none">
                                {{ $order->customer_phone }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Shipping Address</h6>
                </div>
                <div class="card-body">
                    <p class="fw-bold mb-0">
                        {{ $order->shipping_address }}<br>
                        {{ $order->city }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button onclick="window.print()" class="btn btn-outline-primary">
                            <i class="fas fa-print me-2"></i>Print Order
                        </button>
                        
                        <a href="mailto:{{ $order->customer_email }}?subject=Order {{ $order->order_number }} Update" 
                           class="btn btn-outline-info">
                            <i class="fas fa-envelope me-2"></i>Email Customer
                        </a>
                        
                        <button type="button" class="btn btn-outline-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Delete Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete order <strong>{{ $order->order_number }}</strong>?</p>
                <p class="text-danger"><small>This action cannot be undone and will remove all order data.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .navbar, .sidebar, .modal, .card-header .btn {
        display: none !important;
    }
    .container-fluid {
        max-width: 100% !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>
@endsection