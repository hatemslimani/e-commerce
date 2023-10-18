@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Message -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="success-icon mx-auto mb-3">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="mb-2">Thank You for Your Order!</h4>
                        <p class="text-muted mb-0">Order #{{ $order->id }}</p>
                    </div>
                    <p class="mb-4">We've sent you an email with your order details and tracking information.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                            <i class="bi bi-eye"></i> View Order Details
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-shop"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Summary</h5>

                    <!-- Order Items -->
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center mb-3">
                        <div class="product-image-container me-3" style="width: 60px; height: 60px;">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                alt="{{ $item->product->name }}"
                                class="img-thumbnail"
                                style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                <i class="bi bi-image text-muted" style="font-size: 1.5rem;"></i>
                            </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                            <small class="text-muted">Quantity: {{ $item->quantity }}</small>
                        </div>
                        <div class="text-end">
                            <div>${{ number_format($item->price * $item->quantity, 2) }}</div>
                        </div>
                    </div>
                    @endforeach

                    <hr>

                    <!-- Order Totals -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span>${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>${{ number_format($order->total_amount, 2) }}</strong>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Shipping Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Shipping Address</h6>
                            <p class="mb-0">
                                {{ $order->shipping_address->street }}<br>
                                {{ $order->shipping_address->city }}, {{ $order->shipping_address->state }} {{ $order->shipping_address->postal_code }}<br>
                                {{ $order->shipping_address->country }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Payment Method</h6>
                            <p class="mb-0">
                                {{ ucfirst($order->payment_method) }}<br>
                                <small class="text-muted">Payment Status: <span class="text-success">Paid</span></small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .success-icon {
        width: 80px;
        height: 80px;
        background-color: rgba(25, 135, 84, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush
@endsection