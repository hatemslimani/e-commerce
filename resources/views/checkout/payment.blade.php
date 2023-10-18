@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Payment Form -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Payment Information</h5>
                    <form action="{{ route('checkout.process') }}" method="POST" id="payment-form">
                        @csrf
                        <input type="hidden" name="payment_method" value="stripe">

                        <!-- Card Number -->
                        <div class="mb-4">
                            <label class="form-label">Card Number</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-credit-card"></i>
                                </span>
                                <input type="text" class="form-control" id="card-number" placeholder="1234 5678 9012 3456" required>
                            </div>
                            <div id="card-number-error" class="invalid-feedback d-none"></div>
                        </div>

                        <div class="row g-3">
                            <!-- Expiry Date -->
                            <div class="col-md-6">
                                <label class="form-label">Expiry Date</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" id="card-expiry" placeholder="MM/YY" required>
                                </div>
                                <div id="card-expiry-error" class="invalid-feedback d-none"></div>
                            </div>

                            <!-- CVC -->
                            <div class="col-md-6">
                                <label class="form-label">CVC</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-shield-lock"></i>
                                    </span>
                                    <input type="text" class="form-control" id="card-cvc" placeholder="123" required>
                                </div>
                                <div id="card-cvc-error" class="invalid-feedback d-none"></div>
                            </div>
                        </div>

                        <!-- Name on Card -->
                        <div class="mb-4">
                            <label class="form-label">Name on Card</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" class="form-control" id="card-name" placeholder="John Doe" required>
                            </div>
                            <div id="card-name-error" class="invalid-feedback d-none"></div>
                        </div>

                        <!-- Billing Address -->
                        <div class="mb-4">
                            <label class="form-label">Billing Address</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    <i class="bi bi-geo-alt"></i>
                                </span>
                                <input type="text" class="form-control" id="billing-address" placeholder="Street Address" required>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="billing-city" placeholder="City" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="billing-state" placeholder="State" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="billing-zip" placeholder="ZIP Code" required>
                                </div>
                            </div>
                        </div>

                        <!-- Save Card -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="save-card">
                                <label class="form-check-label" for="save-card">Save card for future purchases</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="submit-button">
                            <i class="bi bi-lock"></i> Pay ${{ number_format($order->total_amount, 2) }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Security Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-shield-check text-primary me-2"></i>
                        <h6 class="mb-0">Secure Payment</h6>
                    </div>
                    <p class="text-muted mb-0">Your payment information is encrypted and secure. We never store your full card details on our servers.</p>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
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

            <!-- Shipping Address -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Shipping Address</h5>
                    <p class="mb-0">
                        {{ $order->shipping_address->street }}<br>
                        {{ $order->shipping_address->city }}, {{ $order->shipping_address->state }} {{ $order->shipping_address->postal_code }}<br>
                        {{ $order->shipping_address->country }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }

    .input-group .form-control {
        border-left: none;
    }

    .input-group .form-control:focus {
        border-color: #dee2e6;
    }

    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: #86b7fe;
    }
</style>
@endpush

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('
        services.stripe.key ') }}');
    const elements = stripe.elements();

    // Create card Element and mount it
    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#9e2146'
            }
        }
    });
    card.mount('#card-number');

    // Handle form submission
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';

        try {
            const {
                token,
                error
            } = await stripe.createToken(card);

            if (error) {
                const errorElement = document.getElementById('card-number-error');
                errorElement.textContent = error.message;
                errorElement.classList.remove('d-none');
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="bi bi-lock"></i> Pay ${{ number_format($order->total_amount, 2) }}';
            } else {
                // Add token to form
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit form
                form.submit();
            }
        } catch (error) {
            console.error('Error:', error);
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="bi bi-lock"></i> Pay ${{ number_format($order->total_amount, 2) }}';
        }
    });
</script>
@endpush
@endsection