@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>{{ $category->name }}</h2>
            <p class="text-muted">{{ $category->description }}</p>
        </div>
        <div class="col-auto">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Sort By
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Price: High to Low</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}">Name: A to Z</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}">Name: Z to A</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 product-card">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                @else
                <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No image available">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                        @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                        @else
                        <button class="btn btn-secondary" disabled>Out of Stock</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col">
            <div class="alert alert-info">
                No products found in this category.
            </div>
        </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection