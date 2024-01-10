<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_status',
        'shipping_address',
        'billing_address',
        'payment_method',
        'invoice_number',
        'additional_notes',
        'placed_at',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
