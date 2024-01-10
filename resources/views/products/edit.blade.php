@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5 mb-4">Edit Product</h2>

        <form action="{{ route('products.update', ['id' => $product->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" value="{{ $product->price }}" class="form-control" required>
            </div>

            <!-- Add other fields as needed -->

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>

        </form>
    </div>
@endsection
