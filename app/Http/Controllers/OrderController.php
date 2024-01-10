<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function show($id)
    {
        // Retrieve the order with its associated items and user
        $order = Order::findOrFail($id);

        // You can add more logic here based on your requirements

        return view('checkout.payment_page', compact('order'));
    }
}
