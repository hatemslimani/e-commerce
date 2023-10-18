@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Order Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Order #{{ $order->id }}</h5>
                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="progress mb-4" style="height: 4px;">
                        @php
                        $progress = 0;
                        switch($order->status) {
                        case 'pending':
                        $progress = 25;
                        break;
                        case 'processing':
                        $progress = 50;
                        break;
                        case 'shipped':
                        $progress = 75;
                        break;
                        case 'completed':
                        $progress = 100;
                        break;
                        }
                        @endphp
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Order Date</h6>
                            <p class="mb-0">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Payment Method</h6>
                            <p class="mb-0">{{ ucfirst($order->payment_method) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Items</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
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
                                            <div>
                                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td><strong>${{ number_format($order->subtotal, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tax:</strong></td>
                                    <td><strong>${{ number_format($order->tax, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                    <td><strong>${{ number_format($order->shipping_cost, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Shipping Address -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Shipping Address</h5>
                    <p class="mb-0">
                        {{ $order->shipping_address->street }}<br>
                        {{ $order->shipping_address->city }}, {{ $order->shipping_address->state }} {{ $order->shipping_address->postal_code }}<br>
                        {{ $order->shipping_address->country }}
                    </p>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->notes)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Notes</h5>
                    <p class="mb-0">{{ $order->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Order Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Actions</h5>
                    @if($order->status === 'completed' && !$order->review)
                    <form action="{{ route('orders.review', $order) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-star"></i> Write a Review
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection