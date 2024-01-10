<!-- resources/views/checkout/payment_page.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h1 class="text-center">Payment Page</h1>

                <div class="card mt-4">
                    <div class="card-header">
                        <h2>Order Details</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Order ID:</strong> {{ $order->id }}</p>
                        <p><strong>Total Amount:</strong> ${{ $order->total_amount }}</p>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Order Items</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($order->items as $item)
                                <li class="list-group-item">
                                    {{ $item->product->name }} - Quantity: {{ $item->quantity }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Include your payment processing information or form here -->

                <div class="text-center mt-4">
                    <button class="btn btn-success">Proceed to Payment</button>
                </div>
            </div>
        </div>
    </div>
@endsection
