<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //
    public function showCheckoutForm()
    {
        return view('checkout.form');
    }

    public function placeOrder(Request $request)
    {
        // Validate the form data (add your validation rules here)
        // Validate the incoming request data
        $request->validate([
            'invoice_number' => 'required|string|unique:orders,invoice_number',
            'additional_notes' => 'nullable|string',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'placed_at' => 'required|date',
            // Add more validation rules for other fields if needed
        ]);
 
        // Process the order (store in the database, etc.)
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        // Fetch all products related to the cart items in one query
        $productIds = $cartItems->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get();

        // Calculate total amount
        $totalAmount = $cartItems->sum(function ($item) use ($products) {
            $product = $products->where('id', $item->product_id)->first();

            if ($product) {
                return $product->price * $item->quantity;
            }

            return 0; // or any default value if the product is not found
        });

        // Create an order
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'invoice_number' => $request->input('invoice_number'),
            'additional_notes' => $request->input('additional_notes'),
            'shipping_address' => $request->input('shipping_address'),
            'billing_address' => $request->input('billing_address'),
            'placed_at' => $request->input('placed_at'),
        ]);

        // Move cart items to order items
        foreach ($cartItems as $cartItem) {
            $product = $products->where('id', $cartItem->product_id)->first();

            if ($product) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                ]);
            }
        }

        // Clear the cart
        Cart::where('user_id', $user->id)->delete();

        // Redirect to the payment page (placeholder for now)
        return redirect()->route('payment.page', $order->id)->with('success', 'Order placed successfully');
    }
}
