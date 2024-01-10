<!-- resources/views/products/favorites.blade.php -->

@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h2>Favorite Products</h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Product List
        </a>

        @if ($favorites && count($favorites) > 0)
            <ul>
                @foreach ($favorites as $favorite)
                    <li>
                        {{ $favorite->product->name }}

                        <!-- Add to Cart Button -->
                        <form action="{{ route('favorites.addToCart', $favorite->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Add to Cart</button>
                        </form>

                        <!-- Remove from Favorites Button -->
                        <form action="{{ route('favorites.removeFromFavorites', $favorite->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Remove from Favorites</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No favorite products yet.</p>
        @endif
    </div>
@endsection
