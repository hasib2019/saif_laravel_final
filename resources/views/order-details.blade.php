@extends('layouts.app')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="display-6 fw-bold text-primary mb-2">Order Details</h1>
                    <p class="text-muted mb-0">Order #{{ $order->order_number }}</p>
                </div>
                <div>
                    <span class="badge bg-{{ $order->getStatusBadgeColor() }} fs-6 px-3 py-2">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <div class="row">
                <!-- Order Information -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Order Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-1">Order Date</h6>
                                    <p class="fw-bold">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-1">Status</h6>
                                    <span class="badge bg-{{ $order->getStatusBadgeColor() }} fs-6">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            @if($order->notes)
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Order Notes</h6>
                                    <p class="fw-bold">{{ $order->notes }}</p>
                                </div>
                            @endif

                            <div class="border-top pt-3">
                                <h6 class="mb-3">Order Items</h6>
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
                            </div>

                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Total Amount</h5>
                                    <h4 class="mb-0 text-primary fw-bold">${{ $order->getFormattedTotalAmount() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer & Shipping Information -->
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Name</h6>
                            <p class="fw-bold mb-3">{{ $order->customer_name }}</p>
                            
                            <h6 class="text-muted mb-1">Email</h6>
                            <p class="fw-bold mb-3">{{ $order->customer_email }}</p>
                            
                            <h6 class="text-muted mb-1">Phone</h6>
                            <p class="fw-bold mb-0">{{ $order->customer_phone }}</p>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-shipping-fast me-2"></i>Shipping Address</h5>
                        </div>
                        <div class="card-body">
                            <p class="fw-bold mb-0">
                                {{ $order->shipping_address }}<br>
                                {{ $order->city }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg me-md-2">
                        <i class="fas fa-home me-2"></i>Back to Home
                    </a>
                    <button onclick="window.print()" class="btn btn-secondary btn-lg">
                        <i class="fas fa-print me-2"></i>Print Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .navbar, .footer {
        display: none !important;
    }
    .container {
        max-width: 100% !important;
    }
}
</style>
@endsection