@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2>Favorite Products</h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Product List
        </a>

        @if ($favorites && count($favorites) > 0)
            <ul class="list-group">
                @foreach ($favorites as $favorite)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $favorite->product->name }}</span>

                        <!-- Action Buttons -->
                        <div class="btn-group" role="group">
                            <!-- Add to Cart Button -->
                            <form action="{{ route('favorites.addToCart', $favorite->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </button>
                            </form>

                            <!-- Remove from Favorites Button -->
                            <form action="{{ route('favorites.removeFromFavorites', $favorite->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger ms-3">
                                    <i class="bi bi-heart-fill"></i> Remove from Favorites
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mt-3">No favorite products yet.</p>
        @endif
    </div>
@endsection
