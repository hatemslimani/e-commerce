@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <div class="product-image-container mb-4" style="height: 400px; overflow: hidden;">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    class="img-fluid rounded"
                    style="width: 100%; height: 100%; object-fit: cover;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded">
                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            <p class="text-muted mb-3">Category: <a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a></p>

            <div class="mb-4">
                <h2 class="text-primary">${{ number_format($product->price, 2) }}</h2>
            </div>

            <div class="mb-4">
                <p>{{ $product->description }}</p>
            </div>

            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-4">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number"
                            class="form-control"
                            id="quantity"
                            name="quantity"
                            value="1"
                            min="1"
                            max="{{ $product->stock }}"
                            style="width: 100px;">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </form>
            @else
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> This product is currently out of stock.
            </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Product Details</h5>
                    <ul class="list-unstyled">
                        <li><strong>Stock:</strong> {{ $product->stock }}</li>
                        <li><strong>SKU:</strong> {{ $product->sku }}</li>
                        <li><strong>Weight:</strong> {{ $product->weight }} kg</li>
                        <li><strong>Dimensions:</strong> {{ $product->dimensions }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h2 class="mb-4">Related Products</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col">
                <div class="card h-100">
                    <div class="product-image-container" style="height: 200px; overflow: hidden;">
                        @if($relatedProduct->image)
                        <img src="{{ asset('storage/' . $relatedProduct->image) }}"
                            alt="{{ $relatedProduct->name }}"
                            class="card-img-top"
                            style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                        <p class="card-text text-muted">${{ number_format($relatedProduct->price, 2) }}</p>
                        <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-outline-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection