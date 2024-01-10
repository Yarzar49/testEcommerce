<!-- resources/views/orders/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Order Details</h2>

    <p>Order ID: {{ $order->id }}</p>
    <p>Total Amount: ${{ $order->total_amount }}</p>

    <h3>Order Items</h3>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->product->name }} - Quantity: {{ $item->quantity }}</li>
        @endforeach
    </ul>
@endsection
