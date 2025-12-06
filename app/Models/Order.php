<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'product_id',
        'price',
        'qty',
        'status',
        'address',
        'shipping_method',
        'shipping_city',
        'payment_method',
        'voucher_code',
        'note',
        'shipping_fee',
        'total_amount',
        'discount_amount',
    ];

    protected $casts = [
        'price' => 'integer',
        'qty' => 'integer',
        'shipping_fee' => 'integer',
        'total_amount' => 'integer',
        'discount_amount' => 'integer',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
