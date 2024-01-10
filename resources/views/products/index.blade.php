<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Product List</h2>
            <!-- Favorite Count Badge -->


            <div>
                <a href="{{ route('products.favorites') }}" class="btn btn-warning">
                    Favorites
                    <span class="badge badge-dark" id="favoriteBadge"></span>

                </a>
                <a href="{{ route('cart.show') }}" class="btn btn-primary" id="cartButton">
                    Cart
                    <span class="badge badge-light" id="cartBadge"></span>
                </a>
                <a href="{{ route('products.create') }}" class="btn btn-primary ml-2">Add Product</a>



            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>${{ $product->price }}</td>
                        <td>
                            <!-- Favorite Button -->
                            <form action="{{ route('products.toggleFavorite', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn btn-sm {{ $product->isFavorited ? 'btn-danger' : 'btn-outline-danger' }}">
                                    {{ $product->isFavorited ? 'Remove from Favorites' : 'Add to Favorites' }}
                                </button>
                            </form>
                            <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST"
                                class="mb-2">
                                @csrf

                                <label for="quantity" class="mr-2 mt-4">Quantity:</label>
                                <input type="number" name="quantity" min="1" value="1"
                                    class="form-control-sm mr-2">
                                <button type="submit" class="btn btn-sm btn-success">Add to Cart</button>
                            </form>

                            <a href="{{ route('products.edit', ['id' => $product->id]) }}"
                                class="btn btn-sm btn-warning mr-2">Edit</a>

                            <form action="{{ route('products.destroy', ['id' => $product->id]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        // Function to update the cart badge
        function updateCartBadge() {
            $.ajax({
                url: "{{ route('cart.quantity') }}",
                method: 'GET',
                success: function(data) {
                    $('#cartBadge').text(data);
                }
            });
        }

        // Function to update the favorite badge
        function updateFavoriteBadge() {
            $.ajax({
                url: "{{ route('products.favoriteCount') }}",
                method: 'GET',
                success: function(data) {
                    $('#favoriteBadge').text(data);
                }
            });
        }
        // Update the cart badge on page load
        $(document).ready(function() {
            updateCartBadge();
            updateFavoriteBadge();
        });
    </script>
@endsection
