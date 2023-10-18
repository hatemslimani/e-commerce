@extends('layouts.app')

@section('title', 'Welcome')

@section('content')

<div class="bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold mb-4">Welcome to Our Store</h1>
                <p class="lead mb-4">Discover amazing products at great prices. Shop the latest trends with confidence.</p>
                <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-shop"></i> Start Shopping
                </a>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('images/undraw_online-shopping_hgf6.png') }}" alt="Shopping" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3">Shop by Category</h2>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">View All Categories</a>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                        @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}"
                            alt="{{ $category->name }}"
                            class="card-img-top"
                            style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-grid text-muted" style="font-size: 3rem;"></i>
                        </div>
                        @endif
                        <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                            <h5 class="card-title text-white mb-0">{{ $category->name }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">{{ Str::limit($category->description, 100) }}</p>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-primary">
                            View Products
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3">Featured Products</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">View All Products</a>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($featuredProducts as $product)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="card-img-top"
                            style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                        @endif
                        @if($product->stock <= 0)
                            <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-danger">Out of Stock</span>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                        @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
</div>
</section>

<section class="py-5 bg-light rounded-3 mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="text-center">
                <i class="bi bi-truck text-primary" style="font-size: 2.5rem;"></i>
                <h3 class="h5 mt-3">Free Shipping</h3>
                <p class="text-muted">On orders over $50</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <i class="bi bi-shield-check text-primary" style="font-size: 2.5rem;"></i>
                <h3 class="h5 mt-3">Secure Payment</h3>
                <p class="text-muted">100% secure payment</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <i class="bi bi-arrow-counterclockwise text-primary" style="font-size: 2.5rem;"></i>
                <h3 class="h5 mt-3">Easy Returns</h3>
                <p class="text-muted">30 days return policy</p>
            </div>
        </div>
    </div>
</section>
</div>
@endsection