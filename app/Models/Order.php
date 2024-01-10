<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

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
