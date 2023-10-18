@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container">
    <h2 class="mb-4">Shop by Category</h2>

    <div class="row">
        @forelse($categories as $category)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}">
                @else
                <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No image available">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <p class="card-text">{{ Str::limit($category->description, 100) }}</p>
                    <a href="{{ route('categories.show', $category) }}" class="btn btn-primary">View Products</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col">
            <div class="alert alert-info">
                No categories found.
            </div>
        </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection