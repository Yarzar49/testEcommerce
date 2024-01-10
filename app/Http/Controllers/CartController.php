<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //
    public function addToCart(Request $request, $productId)
    {
        $user = auth()->user(); //auth()->user() is a convenient way to retrieve the currently authenticated user

        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // $cartItem->increment('quantity');
            $cartItem->update(['quantity' => ($cartItem->quantity + $request->quantity)]);
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function totalQuantityInCart()
    {

        $userId = auth()->id();

        $totalQuantityInCart = DB::table('carts')
            ->where('user_id', $userId)
            ->sum('quantity');

        // $cartCount = DB::table('carts')
        //     ->where('user_id', $userId)
        //     ->count();
        return response()->json($totalQuantityInCart);
    }

    public function showCart()
    {
        $user = auth()->user();

        $productIdsInCart = DB::table('carts')
            ->where('user_id', $user->id)
            ->pluck('product_id');

        $productsInCart = DB::table('products')
            ->whereIn('id', $productIdsInCart)
            ->get();

        $cartItems = Cart::where('user_id', $user->id)->get();

        return view('cart.index', compact('productsInCart', 'cartItems'));
    }

    public function updateCart(Request $request)
    {
        foreach ($request->input('quantity') as $cartItemId => $quantity) {
            Cart::where('id', $cartItemId)->update(['quantity' => $quantity]);
        }

        return redirect()->back()->with('success', 'Cart updated successfully');
    }

    public function removeFromCart($cartItemId)
    {
        Cart::destroy($cartItemId);

        return redirect()->back()->with('success', 'Product removed from cart successfully');
    }

    // public function checkout()
    // {
    //     $user = auth()->user();
    //     $cartItems = Cart::where('user_id', $user->id)->get();

    //     // Fetch all products related to the cart items in one query
    //     $productIds = $cartItems->pluck('product_id');
    //     $products = Product::whereIn('id', $productIds)->get();

    //     // Calculate total amount
    //     $totalAmount = $cartItems->sum(function ($item) use ($products) {
    //         $product = $products->where('id', $item->product_id)->first();

    //         if ($product) {
    //             return $product->price * $item->quantity;
    //         }

    //         return 0; // or any default value if the product is not found
    //     });

    //     // Create an order
    //     $order = Order::create([
    //         'user_id' => $user->id,
    //         'total_amount' => $totalAmount,
    //     ]);

    //     // Move cart items to order items
    //     foreach ($cartItems as $cartItem) {
    //         $product = $products->where('id', $cartItem->product_id)->first();

    //         if ($product) {
    //             $order->items()->create([
    //                 'product_id' => $product->id,
    //                 'quantity' => $cartItem->quantity,
    //             ]);
    //         }
    //     }

    //     // Clear the cart
    //     Cart::where('user_id', $user->id)->delete();

    //     return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully');
    // }
}
