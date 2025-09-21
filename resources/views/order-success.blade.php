@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h1 class="display-4 fw-bold text-success mb-3">Order Confirmed!</h1>
                <p class="lead text-muted">Thank you for your order. We've received your order and will process it shortly.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Order Number</h6>
                            <p class="fw-bold fs-5 text-primary">{{ $order->order_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Order Date</h6>
                            <p class="fw-bold">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Customer Name</h6>
                            <p class="fw-bold">{{ $order->customer_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Email</h6>
                            <p class="fw-bold">{{ $order->customer_email }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Shipping Address</h6>
                        <p class="fw-bold">
                            {{ $order->shipping_address }}<br>
                            {{ $order->city }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}
                        </p>
                    </div>

                    <div class="border-top pt-4">
                        <h6 class="mb-3">Order Items</h6>
                        @foreach($order->orderItems as $item)
                            <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded">
                                <div class="d-flex align-items-center">
                                    @if($item->product_image)
                                        <img src="{{ asset('storage/' . $item->product_image) }}" 
                                             alt="{{ $item->product_name }}" 
                                             class="img-thumbnail me-3" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-white d-flex align-items-center justify-content-center me-3" 
                                             style="width: 60px; height: 60px;">
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

            <div class="text-center mt-5">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>What's Next?</strong><br>
                    We'll send you an email confirmation shortly. Our team will process your order and contact you with shipping details.
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-md-2">
                        <i class="fas fa-home me-2"></i>Continue Shopping
                    </a>
                    <a href="{{ route('order.show', $order->order_number) }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-eye me-2"></i>View Order Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection