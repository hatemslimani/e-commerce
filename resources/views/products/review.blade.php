@extends('layouts.app')

@section('title', 'Review Product')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Review Form -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Write a Review</h5>
                    <form action="{{ route('products.review', $product) }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label">Rating</label>
                            <div class="rating">
                                @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="d-none" required>
                                <label for="star{{ $i }}" class="rating-star">
                                    <i class="bi bi-star"></i>
                                </label>
                                @endfor
                            </div>
                            @error('rating')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Review Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label">Review Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Review Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label">Your Review</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pros -->
                        <div class="mb-4">
                            <label for="pros" class="form-label">Pros</label>
                            <textarea class="form-control @error('pros') is-invalid @enderror"
                                id="pros" name="pros" rows="3">{{ old('pros') }}</textarea>
                            <div class="form-text">What did you like about this product?</div>
                            @error('pros')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cons -->
                        <div class="mb-4">
                            <label for="cons" class="form-label">Cons</label>
                            <textarea class="form-control @error('cons') is-invalid @enderror"
                                id="cons" name="cons" rows="3">{{ old('cons') }}</textarea>
                            <div class="form-text">What could be improved?</div>
                            @error('cons')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Photos -->
                        <div class="mb-4">
                            <label class="form-label">Photos</label>
                            <input type="file" class="form-control @error('photos.*') is-invalid @enderror"
                                name="photos[]" multiple accept="image/*">
                            <div class="form-text">You can upload up to 5 photos</div>
                            @error('photos.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Submit Review
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product Reviews -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Customer Reviews</h5>
                    @if($product->reviews->count() > 0)
                    @foreach($product->reviews as $review)
                    <div class="review-item mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">{{ $review->title }}</h6>
                                <div class="rating text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                </div>
                            </div>
                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                        </div>
                        <p class="mb-2">{{ $review->content }}</p>
                        @if($review->pros || $review->cons)
                        <div class="row g-3">
                            @if($review->pros)
                            <div class="col-md-6">
                                <div class="p-3 bg-success bg-opacity-10 rounded">
                                    <h6 class="text-success mb-2">Pros</h6>
                                    <p class="mb-0">{{ $review->pros }}</p>
                                </div>
                            </div>
                            @endif
                            @if($review->cons)
                            <div class="col-md-6">
                                <div class="p-3 bg-danger bg-opacity-10 rounded">
                                    <h6 class="text-danger mb-2">Cons</h6>
                                    <p class="mb-0">{{ $review->cons }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                        @if($review->photos->count() > 0)
                        <div class="mt-3">
                            <div class="row g-2">
                                @foreach($review->photos as $photo)
                                <div class="col-auto">
                                    <img src="{{ asset('storage/' . $photo->path) }}"
                                        alt="Review photo"
                                        class="img-thumbnail"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-star text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">No reviews yet. Be the first to review this product!</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="product-image-container mx-auto mb-3" style="width: 200px; height: 200px;">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="img-thumbnail"
                                style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                            @endif
                        </div>
                        <h5 class="mb-1">{{ $product->name }}</h5>
                        <p class="text-muted mb-0">SKU: {{ $product->sku }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Average Rating</span>
                        <div class="rating text-warning">
                            @php
                            $rating = $product->reviews->avg('rating') ?? 0;
                            $rating = round($rating * 2) / 2;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $rating ? '-fill' : ($i - 0.5 <= $rating ? '-half' : '') }}"></i>
                                @endfor
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Total Reviews</span>
                        <span class="text-muted">{{ $product->reviews->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        font-size: 1.5rem;
        color: #ddd;
        padding: 0 0.2rem;
    }

    .rating label:hover,
    .rating label:hover~label,
    .rating input:checked~label {
        color: #ffc107;
    }

    .rating input:checked~label {
        color: #ffc107;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ratingInputs = document.querySelectorAll('.rating input');
        const ratingLabels = document.querySelectorAll('.rating label');

        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                const value = this.value;
                ratingLabels.forEach(label => {
                    const star = label.querySelector('i');
                    if (label.getAttribute('for') === `star${value}`) {
                        star.classList.remove('bi-star');
                        star.classList.add('bi-star-fill');
                    } else {
                        star.classList.remove('bi-star-fill');
                        star.classList.add('bi-star');
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection