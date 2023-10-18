@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">My Orders</h1>

    @if($orders->count() > 0)
    <div class="row g-4">
        @foreach($orders as $order)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="card-title mb-1">Order #{{ $order->id }}</h5>
                            <p class="text-muted mb-0">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <!-- Order Progress -->
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

                    <!-- Order Items -->
                    <div class="mb-4">
                        @foreach($order->items->take(2) as $item)
                        <div class="d-flex align-items-center mb-2">
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
                        @if($order->items->count() > 2)
                        <div class="text-center">
                            <small class="text-muted">+{{ $order->items->count() - 2 }} more items</small>
                        </div>
                        @endif
                    </div>

                    <!-- Order Summary -->
                    <div class="border-top pt-3">
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

                    <!-- Order Actions -->
                    <div class="mt-4">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-eye"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-bag-x text-muted" style="font-size: 4rem;"></i>
        <h3 class="mt-3">No orders yet</h3>
        <p class="text-muted">Looks like you haven't placed any orders yet.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            <i class="bi bi-shop"></i> Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection