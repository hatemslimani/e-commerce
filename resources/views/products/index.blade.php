@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Our Products</h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Sort By
            </button>
            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                <li><a class="dropdown-item" href="{{ route('products.index', ['sort' => 'price_asc']) }}">Price: Low to High</a></li>
                <li><a class="dropdown-item" href="{{ route('products.index', ['sort' => 'price_desc']) }}">Price: High to Low</a></li>
                <li><a class="dropdown-item" href="{{ route('products.index', ['sort' => 'name_asc']) }}">Name: A to Z</a></li>
                <li><a class="dropdown-item" href="{{ route('products.index', ['sort' => 'name_desc']) }}">Name: Z to A</a></li>
            </ul>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($products as $product)
        <div class="col">
            <div class="card h-100">
                <div class="product-image-container" style="height: 200px; overflow: hidden;">
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
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                        @else
                        <button class="btn btn-secondary" disabled>
                            <i class="bi bi-x-circle"></i> Out of Stock
                        </button>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                No products found.
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection