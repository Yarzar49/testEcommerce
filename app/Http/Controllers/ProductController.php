<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required',
            'price' => 'required|numeric',
            // Add other validation rules as needed
        ]);

        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        // Save the product to the database
        $product->save();


        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required',
            'price' => 'required|numeric',
            // Add other validation rules as needed
        ]);
        $product = Product::find($id);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        // Save the product to the database
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function toggleFavorite($productId)
    {
        $user = auth()->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'Product removed from favorites.');
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            return redirect()->back()->with('success', 'Product added to favorites.');
        }

        
    }

    public function favorites()
    {
        $user = auth()->user();
        $favorites = $user->favorites;

        $favorites = Favorite::where('user_id', $user->id)->get();
        
        return view('products.favorites', ['favorites' => $favorites]);
    }

    public function favoriteCount()
    {
        // Fetch the authenticated user's favorite count
        $user = auth()->user();
        $favoriteCount = Favorite::where('user_id', $user->id)->count();
        // dd($favoriteCount);

        // Return the count as a plain number
        return $favoriteCount;
    }
}
