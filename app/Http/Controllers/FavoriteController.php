<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    //
    public function addToCart($favoriteId)
    {
        $favorite = Favorite::findOrFail($favoriteId);
        Cart::create([
            'user_id' => $favorite->user_id,
            'product_id' => $favorite->product_id,
            'quantity' => 1,
        ]);
        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function removeFromFavorites($favoriteId)
    {
        $favorite = Favorite::findOrFail($favoriteId);
        $favorite->delete();

        return redirect()->back()->with('success', 'Product removed from favorites.');
    }
}
