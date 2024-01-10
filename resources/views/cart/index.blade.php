<!-- resources/views/cart/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Product List
        </a>
        <h2>Your Shopping Cart</h2>

        @if (count($cartItems) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            @foreach ($productsInCart as $productInCart)
                                @if ($cartItem->product_id === $productInCart->id)
                                    <td>{{ $productInCart->name }}</td>
                                @endif
                            @endforeach
                            <td>
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="number" name="quantity[{{ $cartItem->id }}]"
                                            value="{{ $cartItem->quantity }}" min="1" class="form-control">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('cart.remove', $cartItem->id) }}" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <a href="{{ route('checkout.form') }}" class="btn btn-success">Proceed to Checkout</a>
            </div>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
@endsection
