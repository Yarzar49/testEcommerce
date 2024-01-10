<!-- resources/views/checkout/form.blade.php -->

@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container mt-4">
        <h2>Checkout</h2>
        <form action="{{ route('place.order') }}" method="POST">
            @csrf

            <!-- Other order form fields -->

            {{-- <div class="mb-3">
                <label for="invoice_number" class="form-label">Invoice Number:</label>
                <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number') }}"
                    class="form-control" required />
            </div> --}}

            <div class="mb-3">
                <label for="additional_notes" class="form-label">Additional Notes:</label>
                <textarea name="additional_notes" id="additional_notes" class="form-control" rows="3">{{ old('additional_notes') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="shipping_address" class="form-label">Shipping Address:</label>
                <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="billing_address" class="form-label">Billing Address:</label>
                <textarea name="billing_address" id="billing_address" class="form-control" rows="3" required>{{ old('billing_address') }}</textarea>
            </div>

            <input type="hidden" name="placed_at" value="{{ now() }}" />

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Place Order</button>
            </div>
        </form>
    </div>
@endsection
